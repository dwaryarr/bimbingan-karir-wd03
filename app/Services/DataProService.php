<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class DataProService
{
    protected $token;
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.onedbdatapro.url'), '/');
    }

    private function makeRequest($url, $data = [], $headers = [])
    {
        // Try with file_get_contents first (avoid cURL chunked encoding issues)
        try {
            return $this->makeRequestWithFileGetContents($url, $data, $headers);
        } catch (\Exception $e) {
            // Fallback to cURL if file_get_contents fails
            return $this->makeRequestWithCurl($url, $data, $headers);
        }
    }

    private function makeRequestWithFileGetContents($url, $data = [], $headers = [])
    {
        $postData = json_encode($data);

        $defaultHeaders = [
            'Content-Type: application/json',
            'Accept: application/json',
            'Content-Length: ' . strlen($postData),
            'Connection: close',
            'Cache-Control: no-cache',
            'Pragma: no-cache',
        ];

        $allHeaders = array_merge($defaultHeaders, $headers);

        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => implode("\r\n", $allHeaders),
                'content' => $postData,
                'timeout' => 30,
                'ignore_errors' => true,
                'protocol_version' => 1.0, // Use HTTP/1.0 to avoid chunked encoding
            ],
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
            ],
        ]);

        $response = file_get_contents($this->baseUrl . $url, false, $context);

        if ($response === false) {
            throw new \Exception('Failed to get response using file_get_contents');
        }

        // Parse HTTP response code from headers
        $httpCode = 200; // Default
        if (isset($http_response_header)) {
            foreach ($http_response_header as $header) {
                if (preg_match('/^HTTP\/[\d\.]+\s+(\d+)/', $header, $matches)) {
                    $httpCode = (int)$matches[1];
                    break;
                }
            }
        }

        // Clean the response - handle chunked encoding if present
        $response = $this->cleanChunkedResponse($response);

        $json = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Invalid JSON response: ' . json_last_error_msg() . ' | Raw: ' . substr($response, 0, 200));
        }

        if ($httpCode < 200 || $httpCode >= 300) {
            throw new \Exception('HTTP Error ' . $httpCode . ': ' . $response);
        }

        return $json;
    }

    private function cleanChunkedResponse($response)
    {
        // Remove BOM if present
        if (substr($response, 0, 3) === "\xEF\xBB\xBF") {
            $response = substr($response, 3);
        }

        // Check if response is chunked encoded
        if (preg_match('/^[0-9a-fA-F]+\r?\n/', $response)) {
            // This looks like chunked encoding, try to decode it
            $decoded = '';
            $offset = 0;

            while ($offset < strlen($response)) {
                // Find the chunk size line
                $newlinePos = strpos($response, "\n", $offset);
                if ($newlinePos === false) break;

                $chunkSizeLine = substr($response, $offset, $newlinePos - $offset);
                $chunkSizeLine = trim($chunkSizeLine);

                // Parse chunk size (hex)
                $chunkSize = hexdec($chunkSizeLine);

                if ($chunkSize === 0) {
                    // Last chunk
                    break;
                }

                // Move past the chunk size line
                $offset = $newlinePos + 1;

                // Extract the chunk data
                $chunkData = substr($response, $offset, $chunkSize);
                $decoded .= $chunkData;

                // Move past the chunk data and trailing CRLF
                $offset += $chunkSize + 2; // +2 for CRLF
            }

            return trim($decoded);
        }

        return trim($response);
    }

    private function makeRequestWithCurl($url, $data = [], $headers = [])
    {
        $ch = curl_init();

        $defaultHeaders = [
            'Content-Type: application/json',
            'Accept: application/json',
            'Content-Length: ' . strlen(json_encode($data)),
            'Connection: close',
            'Cache-Control: no-cache',
            'Pragma: no-cache',
        ];

        $allHeaders = array_merge($defaultHeaders, $headers);

        curl_setopt_array($ch, [
            CURLOPT_URL => $this->baseUrl . $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => $allHeaders,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_0,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_HEADER => false,
            CURLOPT_NOBODY => false,
            CURLOPT_ENCODING => '',
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_MAXREDIRS => 0,
            CURLOPT_BUFFERSIZE => 16384,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);

        curl_close($ch);

        if ($error) {
            throw new \Exception('cURL Error: ' . $error . ' | URL: ' . $this->baseUrl . $url);
        }

        if ($response === false || empty($response)) {
            throw new \Exception('Empty response from server. HTTP Code: ' . $httpCode);
        }

        // Clean the response - handle chunked encoding if present
        $response = $this->cleanChunkedResponse($response);

        $json = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Invalid JSON response: ' . json_last_error_msg() . ' | Raw: ' . substr($response, 0, 200));
        }

        if ($httpCode < 200 || $httpCode >= 300) {
            throw new \Exception('HTTP Error ' . $httpCode . ': ' . $response);
        }

        return $json;
    }

    protected function getToken()
    {
        if ($this->token) {
            return $this->token;
        }

        try {
            $response = $this->makeRequest('/api/authenticate', [
                'username' => config('services.onedbdatapro.username'),
                'password' => config('services.onedbdatapro.password'),
            ]);

            if (isset($response['token'])) {
                $this->token = $response['token'];
                return $this->token;
            }

            throw new \Exception('No token found in response');
        } catch (\Exception $e) {
            throw new \Exception('Authentication failed: ' . $e->getMessage());
        }
    }

    public function tokenizeSingle($data, $templateName, $trxId)
    {
        $token = $this->getToken();

        return $this->makeRequest('/api/v1/tokenize?single', [
            'data' => $data,
            'templateName' => $templateName,
            'trxId' => $trxId,
        ], [
            'Authorization: Bearer ' . $token
        ]);
    }

    public function tokenizeMultiple(array $data)
    {
        $token = $this->getToken();

        return $this->makeRequest('/api/v1/tokenize?multiple', $data, [
            'Authorization: Bearer ' . $token
        ]);
    }

    public function tokenizeFields(array $fields, $templateName, $trxId)
    {
        $token = $this->getToken();

        $results = [];

        // Tokenize each field individually using single tokenize
        foreach ($fields as $fieldName => $fieldValue) {
            try {
                $response = $this->makeRequest('/api/v1/tokenize?single', [
                    'data' => $fieldValue,
                    'templateName' => $templateName,
                    'trxId' => $trxId,
                ], [
                    'Authorization: Bearer ' . $token
                ]);

                $results[$fieldName] = $response;
            } catch (\Exception $e) {
                $results[$fieldName] = ['error' => $e->getMessage()];
            }
        }

        return $results;
    }

    public function detokenizeSingle($token, $templateName, $trxId)
    {
        $accessToken = $this->getToken();

        return $this->makeRequest('/api/v1/detokenize?single', [
            'token' => $token,
            'templateName' => $templateName,
            'trxId' => $trxId,
        ], [
            'Authorization: Bearer ' . $accessToken
        ]);
    }

    public function detokenizeMultiple(array $data)
    {
        $token = $this->getToken();

        return $this->makeRequest('/api/v1/detokenize?multiple', $data, [
            'Authorization: Bearer ' . $token
        ]);
    }

    public function detokenizeFields(array $tokenizedFields, $templateName, $trxId)
    {
        $accessToken = $this->getToken();
        $results = [];

        // Detokenize each field individually using single detokenize
        foreach ($tokenizedFields as $fieldName => $tokenData) {
            try {
                // Extract token from response if it's an array
                $tokenValue = is_array($tokenData) && isset($tokenData['token'])
                    ? $tokenData['token']
                    : $tokenData;

                $response = $this->makeRequest('/api/v1/detokenize?single', [
                    'token' => $tokenValue,
                    'templateName' => $templateName,
                    'trxId' => $trxId,
                ], [
                    'Authorization: Bearer ' . $accessToken
                ]);

                $results[$fieldName] = $response;
            } catch (\Exception $e) {
                $results[$fieldName] = ['error' => $e->getMessage()];
            }
        }

        return $results;
    }

    public function tokenizeBatch(array $dataArray, $templateName, $trxId)
    {
        $token = $this->getToken();
        $results = [];

        // Tokenize multiple data items individually
        foreach ($dataArray as $index => $data) {
            try {
                $response = $this->makeRequest('/api/v1/tokenize?single', [
                    'data' => $data,
                    'templateName' => $templateName,
                    'trxId' => $trxId,
                ], [
                    'Authorization: Bearer ' . $token
                ]);

                $results[$index] = $response;
            } catch (\Exception $e) {
                $results[$index] = ['error' => $e->getMessage()];
            }
        }

        return $results;
    }

    public function detokenizeBatch(array $tokens, $templateName, $trxId)
    {
        $accessToken = $this->getToken();
        $results = [];

        // Detokenize multiple tokens individually
        foreach ($tokens as $index => $token) {
            try {
                $response = $this->makeRequest('/api/v1/detokenize?single', [
                    'token' => $token,
                    'templateName' => $templateName,
                    'trxId' => $trxId,
                ], [
                    'Authorization: Bearer ' . $accessToken
                ]);

                $results[$index] = $response;
            } catch (\Exception $e) {
                $results[$index] = ['error' => $e->getMessage()];
            }
        }

        return $results;
    }

    // Utility method to check token status
    public function checkTokenStatus($token, $templateName, $trxId)
    {
        try {
            $response = $this->detokenizeSingle($token, $templateName, $trxId);
            return [
                'valid' => isset($response['success']) && $response['success'],
                'response' => $response
            ];
        } catch (\Exception $e) {
            return [
                'valid' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    // Method to get available templates (if API supports it)
    public function getTemplates()
    {
        $token = $this->getToken();

        try {
            return $this->makeRequest('/api/v1/templates', [], [
                'Authorization: Bearer ' . $token
            ]);
        } catch (\Exception $e) {
            // If templates endpoint doesn't exist, return default
            return [
                'templates' => ['App_Without_Masking', 'default'],
                'note' => 'Default templates (API endpoint may not be available)'
            ];
        }
    }
}
