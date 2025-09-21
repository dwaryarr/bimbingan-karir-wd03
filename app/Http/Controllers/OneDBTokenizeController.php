<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DataProService;

class OneDBTokenizeController extends Controller
{
    public function tokenizeSingle(Request $request)
    {
        $dataProService = new DataProService();

        // For single tokenize, data should be a string, not an array
        $data = 'John Doe'; // Example single value
        $response = $dataProService->tokenizeSingle($data, 'App_Without_Masking', 99);

        return response()->json($response);
    }

    public function tokenizeFields(Request $request)
    {
        $dataProService = new DataProService();

        // For multiple fields, use tokenizeFields method
        $fields = [
            'nama' => 'John Doe',
            'no_ktp' => '1234567890123456',
            'no_hp' => '081234567890',
        ];
        $response = $dataProService->tokenizeFields($fields, 'App_Without_Masking', 99);

        return response()->json($response);
    }

    public function tokenizeMultiple(Request $request)
    {
        $dataProService = new DataProService();

        // Test original tokenizeMultiple method
        $data = [
            [
                'data' => 'John Doe',
                'templateName' => 'App_Without_Masking',
                'trxId' => 99
            ],
            [
                'data' => 'Jane Smith',
                'templateName' => 'App_Without_Masking',
                'trxId' => 100
            ]
        ];

        try {
            $response = $dataProService->tokenizeMultiple($data);
        } catch (\Exception $e) {
            // If multiple endpoint fails, use batch method as fallback
            $batchData = ['John Doe', 'Jane Smith'];
            $response = $dataProService->tokenizeBatch($batchData, 'App_Without_Masking', 99);
        }

        return response()->json($response);
    }

    public function tokenizeBatch(Request $request)
    {
        $dataProService = new DataProService();

        // Tokenize batch of data
        $dataArray = [
            'John Doe',
            'Jane Smith',
            'Bob Johnson',
            '1234567890123456',
            '081234567890'
        ];

        $response = $dataProService->tokenizeBatch($dataArray, 'App_Without_Masking', 99);

        return response()->json($response);
    }

    public function detokenizeSingle(Request $request)
    {
        $dataProService = new DataProService();

        // Get a token first by tokenizing
        $tokenizeResponse = $dataProService->tokenizeSingle('John Doe', 'App_Without_Masking', 99);

        if (isset($tokenizeResponse['token'])) {
            $response = $dataProService->detokenizeSingle($tokenizeResponse['token'], 'App_Without_Masking', 99);

            return response()->json([
                'original_tokenize' => $tokenizeResponse,
                'detokenize_result' => $response
            ]);
        }

        return response()->json(['error' => 'Failed to get token for detokenization test']);
    }

    public function detokenizeFields(Request $request)
    {
        $dataProService = new DataProService();

        // First tokenize some fields
        $fields = [
            'nama' => 'John Doe',
            'no_ktp' => '1234567890123456',
            'no_hp' => '081234567890',
        ];

        $tokenizedFields = $dataProService->tokenizeFields($fields, 'App_Without_Masking', 99);

        // Then detokenize them
        $detokenizedFields = $dataProService->detokenizeFields($tokenizedFields, 'App_Without_Masking', 99);

        return response()->json([
            'original_data' => $fields,
            'tokenized' => $tokenizedFields,
            'detokenized' => $detokenizedFields
        ]);
    }

    public function detokenizeBatch(Request $request)
    {
        $dataProService = new DataProService();

        // First create some tokens
        $dataArray = ['John Doe', 'Jane Smith', 'Bob Johnson'];
        $tokenizedBatch = $dataProService->tokenizeBatch($dataArray, 'App_Without_Masking', 99);

        // Extract tokens
        $tokens = [];
        foreach ($tokenizedBatch as $index => $result) {
            if (isset($result['token'])) {
                $tokens[$index] = $result['token'];
            }
        }

        // Detokenize the batch
        $detokenizedBatch = $dataProService->detokenizeBatch($tokens, 'App_Without_Masking', 99);

        return response()->json([
            'original_data' => $dataArray,
            'tokenized' => $tokenizedBatch,
            'detokenized' => $detokenizedBatch
        ]);
    }

    public function checkTokenStatus(Request $request)
    {
        $dataProService = new DataProService();

        // Create a token first
        $tokenizeResponse = $dataProService->tokenizeSingle('Test Data', 'App_Without_Masking', 99);

        if (isset($tokenizeResponse['token'])) {
            $statusCheck = $dataProService->checkTokenStatus(
                $tokenizeResponse['token'],
                'App_Without_Masking',
                99
            );

            return response()->json([
                'token' => $tokenizeResponse['token'],
                'status' => $statusCheck
            ]);
        }

        return response()->json(['error' => 'Failed to create token for status check']);
    }

    public function getTemplates(Request $request)
    {
        $dataProService = new DataProService();
        $response = $dataProService->getTemplates();

        return response()->json($response);
    }

    public function demoAll(Request $request)
    {
        $dataProService = new DataProService();
        $results = [];

        try {
            // 1. Single tokenize
            $results['single_tokenize'] = $dataProService->tokenizeSingle('John Doe', 'App_Without_Masking', 99);

            // 2. Multiple fields tokenize
            $fields = ['nama' => 'John Doe', 'no_ktp' => '1234567890123456'];
            $results['fields_tokenize'] = $dataProService->tokenizeFields($fields, 'App_Without_Masking', 99);

            // 3. Batch tokenize
            $batch = ['Alice', 'Bob', 'Charlie'];
            $results['batch_tokenize'] = $dataProService->tokenizeBatch($batch, 'App_Without_Masking', 99);

            // 4. Detokenize single
            if (isset($results['single_tokenize']['token'])) {
                $results['single_detokenize'] = $dataProService->detokenizeSingle(
                    $results['single_tokenize']['token'],
                    'App_Without_Masking',
                    99
                );
            }

            // 5. Get templates
            $results['templates'] = $dataProService->getTemplates();

            return response()->json([
                'success' => true,
                'message' => 'All operations completed successfully',
                'results' => $results
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'results' => $results
            ]);
        }
    }
}
