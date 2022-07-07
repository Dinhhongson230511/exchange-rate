<?php
namespace App\Base\Support;

use Illuminate\Support\Facades\Log;

/**
 * @method static array call($url, $method, $headers, $requestData, $typeBody, $isParseJson)
 */
class RequestUrl extends BaseSupport
{
    /**
     * requestApi
     *
     * @param  string $url
     * @param  string $method
     * @param  array $header | GET
     * @param  array $requestContent | []
     * @param  array $typeBody | json/form_params
     * @return array
     */
    protected function call(
        string $url,
        string $method = 'GET',
        array $headers = [],
        array $requestData = [],
        string $typeBody = 'json',
        bool $isParseJson = false
    ) {
        $dataResult = [];

        $requestContent = [
            'headers' => $headers,
        ];

        if (strtolower($method) == 'get') {
            $url = $requestData != [] ? $url . '?' . http_build_query($requestData) : $url;
        } else {
            $requestContent[$typeBody] = $requestData;
        }

        try {
            $client = new \GuzzleHttp\Client();
            $request = $client->request($method, $url, $requestContent);
            $dataResult = [
                'status' => $request->getStatusCode(),
                'response' => $isParseJson ? json_decode($request->getBody()->getContents()) : (string) $request->getBody(),
                'headers' => $request->getHeaders(),
            ];

        } catch (\GuzzleHttp\Exception\RequestException $e) {
            if($e->getResponse() !== null) {
                $dataResult = [
                    'status' => $e->getResponse()->getStatusCode(),
                    'response' => [
                        'statusCode' => $e->getResponse()->getStatusCode(),
                        'message' => $e->getResponse()->getReasonPhrase() ?? '',
                    ],
                    'headers' => $e->getResponse()->getHeaders(),
                ];
            }
            Log::error('CALL_API_NOT_SUCCESS with messsage: '. $e->getMessage());
            Log::error('DATA REQUEST API: '. print_r($requestContent, true));
        }

        return $dataResult;
    }
}


