# OneDB DataPro Service Documentation

## Overview

DataPro Service adalah layanan untuk tokenisasi dan detokenisasi data sensitif menggunakan OneDB DataPro API.

## Features Lengkap

### 1. **Single Tokenization**

Tokenisasi satu nilai data tunggal.

```php
$service = new DataProService();
$result = $service->tokenizeSingle('John Doe', 'App_Without_Masking', 99);
// Result: {"trxId":99,"success":true,"token":"2fKW oRW"}
```

### 2. **Fields Tokenization**

Tokenisasi multiple fields dalam satu operasi.

```php
$fields = [
    'nama' => 'John Doe',
    'no_ktp' => '1234567890123456',
    'no_hp' => '081234567890'
];
$result = $service->tokenizeFields($fields, 'App_Without_Masking', 99);
```

### 3. **Batch Tokenization**

Tokenisasi array data secara batch.

```php
$data = ['Alice Smith', 'Bob Johnson', 'Carol Brown'];
$result = $service->tokenizeBatch($data, 'App_Without_Masking', 99);
```

### 4. **Multiple Records Tokenization**

Tokenisasi multiple records dengan format kompleks.

```php
$data = [
    [
        'data' => 'User 1',
        'templateName' => 'App_Without_Masking',
        'trxId' => 99
    ],
    [
        'data' => 'User 2',
        'templateName' => 'App_Without_Masking',
        'trxId' => 100
    ]
];
$result = $service->tokenizeMultiple($data);
```

### 5. **Single Detokenization**

Mengembalikan data asli dari token tunggal.

```php
$result = $service->detokenizeSingle($token, 'App_Without_Masking', 99);
// Result: {"trxId":99,"success":true,"data":"John Doe"}
```

### 6. **Fields Detokenization**

Detokenisasi multiple fields yang telah ditokenisasi.

```php
$tokenizedFields = [
    'nama' => ['token' => '2fKW oRW'],
    'no_ktp' => ['token' => '7868542260962385']
];
$result = $service->detokenizeFields($tokenizedFields, 'App_Without_Masking', 99);
```

### 7. **Batch Detokenization**

Detokenisasi array tokens secara batch.

```php
$tokens = ['2fKW oRW', '7868542260962385', '237051375900'];
$result = $service->detokenizeBatch($tokens, 'App_Without_Masking', 99);
```

### 8. **Token Status Check**

Mengecek validitas dan status token.

```php
$status = $service->checkTokenStatus($token, 'App_Without_Masking', 99);
// Result: {"valid":true,"response":{...}}
```

### 9. **Get Templates**

Mendapatkan daftar template yang tersedia.

```php
$templates = $service->getTemplates();
// Result: {"templates":["App_Without_Masking","default"]}
```

## Available Endpoints

### Tokenization Endpoints

-   `GET /datapro/tokenize-single` - Single value tokenization
-   `GET /datapro/tokenize-fields` - Multiple fields tokenization
-   `GET /datapro/tokenize-multiple` - Multiple records tokenization
-   `GET /datapro/tokenize-batch` - Batch tokenization

### Detokenization Endpoints

-   `GET /datapro/detokenize-single` - Single token detokenization
-   `GET /datapro/detokenize-fields` - Multiple fields detokenization
-   `GET /datapro/detokenize-batch` - Batch detokenization

### Utility Endpoints

-   `GET /datapro/check-token-status` - Check token validity
-   `GET /datapro/templates` - Get available templates
-   `GET /datapro/demo-all` - Demo all features

### Legacy Endpoints (Backward Compatibility)

-   `GET /testTokenize` - Single tokenization test
-   `GET /testTokenizeFields` - Fields tokenization test

## Configuration

Pastikan konfigurasi di `.env` sudah benar:

```env
DATAPRO_URL=http://192.168.1.100:8282/
DATAPRO_UNAME=poliklinik-lv
DATAPRO_PWORD=poliklinik-lv
```

## Error Handling

Service menggunakan robust error handling dengan:

-   Automatic fallback dari file_get_contents ke cURL
-   Chunked encoding decoder
-   HTTP/1.0 protocol untuk stabilitas
-   Individual error handling per field/item dalam batch operations

## Usage Examples

### Contoh Penggunaan di Controller:

```php
public function tokenizePatientData(Request $request)
{
    $service = new DataProService();

    $patientData = [
        'nama' => $request->nama,
        'no_ktp' => $request->no_ktp,
        'no_hp' => $request->no_hp,
        'alamat' => $request->alamat
    ];

    $tokenizedData = $service->tokenizeFields(
        $patientData,
        'App_Without_Masking',
        $request->user()->id
    );

    return response()->json($tokenizedData);
}
```

### Contoh Detokenisasi:

```php
public function showPatientData($id)
{
    $service = new DataProService();

    // Ambil data yang sudah ditokenisasi dari database
    $patient = Patient::find($id);

    $tokenizedFields = [
        'nama' => ['token' => $patient->tokenized_nama],
        'no_ktp' => ['token' => $patient->tokenized_no_ktp],
        'no_hp' => ['token' => $patient->tokenized_no_hp]
    ];

    $originalData = $service->detokenizeFields(
        $tokenizedFields,
        'App_Without_Masking',
        $patient->created_by
    );

    return response()->json($originalData);
}
```

## Notes

1. **Template Name**: Gunakan 'App_Without_Masking' sebagai template default
2. **Transaction ID**: Gunakan ID unik untuk setiap transaksi (user ID, timestamp, dll)
3. **Error Handling**: Semua method memiliki built-in error handling
4. **Batch Operations**: Ideal untuk processing data dalam jumlah besar
5. **Token Validity**: Gunakan checkTokenStatus() untuk validasi token

## Security Considerations

-   Token disimpan sementara di memory selama session
-   Koneksi menggunakan HTTPS (jika dikonfigurasi)
-   Tidak ada data sensitif yang di-log
-   Authentication token di-refresh otomatis
