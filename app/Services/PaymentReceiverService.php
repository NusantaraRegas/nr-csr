<?php

namespace App\Services;

use App\Helper\APIHelper;

class PaymentReceiverService
{
    /**
     * @return array<int, string>
     */
    public function fetchReceiverNames($userId = '1211'): array
    {
        $payload = [
            'user_id' => (string) $userId,
        ];

        $rawResponse = APIHelper::instance()->httpCallJson(
            'POST',
            env('BASEURL') . '/api/APIPaymentRequest/CreatePaymentRequest',
            $payload,
            ''
        );

        $decoded = $this->decodeApiPayload($rawResponse);
        $collection = data_get($decoded, 'data.dataSupplier.Collection');

        if (!is_array($collection)) {
            throw new \RuntimeException('Invalid data receiver payload: missing supplier collection.');
        }

        $names = [];
        foreach ($collection as $row) {
            $name = trim((string) data_get($row, 'name', ''));
            if ($name === '') {
                continue;
            }

            $names[] = $name;
        }

        return array_values(array_unique($names));
    }

    /**
     * @param array<int, string> $receiverNames
     */
    public function renderLegacyOptions(array $receiverNames): string
    {
        $html = '<option></option>';

        foreach ($receiverNames as $name) {
            $escapedName = e($name);
            $html .= '<option value="' . $escapedName . '">' . $escapedName . '</option>';
        }

        return $html;
    }

    /**
     * @return array<string, mixed>
     */
    private function decodeApiPayload($rawResponse): array
    {
        if (!is_string($rawResponse) || $rawResponse === '') {
            throw new \RuntimeException('Invalid data receiver payload: empty response.');
        }

        $jsonPayload = strstr($rawResponse, '{');
        if ($jsonPayload === false) {
            throw new \RuntimeException('Invalid data receiver payload: JSON body not found.');
        }

        $decoded = json_decode($jsonPayload, true);
        if (!is_array($decoded)) {
            throw new \RuntimeException('Invalid data receiver payload: malformed JSON.');
        }

        return $decoded;
    }
}
