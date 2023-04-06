<?php

class FinalResult {
    const EXPECTED_RECORD_LENGTH = 16;
    const AMOUNT_INDEX = 8;
    const BANK_ACCOUNT_NAME_INDEX = 7;
    const BANK_ACCOUNT_NUMBER_INDEX = 6;
    const BANK_BRANCH_CODE_INDEX = 2;
    const BANK_CODE_INDEX = 0;
    const END_TO_END_ID_1_INDEX = 10;
    const END_TO_END_ID_2_INDEX = 11;

    function results($file) {
        $document = fopen($file, "r");
        [$currency, $failure_code, $failure_message] = fgetcsv($document);
        $records = [];
        while(($record = fgetcsv($document)) !== false) {
			if (count($record) == self::EXPECTED_RECORD_LENGTH) {
                $amount = !$record[self::AMOUNT_INDEX] || $record[self::AMOUNT_INDEX] === "0" ? 0 : (float) $record[self::AMOUNT_INDEX];
                $bank_account_number = !$record[self::BANK_ACCOUNT_NUMBER_INDEX] ? "Bank account number missing" : (int) $record[self::BANK_ACCOUNT_NUMBER_INDEX];
                $bank_branch_code = !$record[self::BANK_BRANCH_CODE_INDEX] ? "Bank branch code missing" : $record[self::BANK_BRANCH_CODE_INDEX];
                $end_to_end_id = !$record[self::END_TO_END_ID_1_INDEX] && !$record[self::END_TO_END_ID_2_INDEX] ? "End to end id missing" : $record[self::END_TO_END_ID_1_INDEX] . $record[self::END_TO_END_ID_2_INDEX];
                $records[] = [
                    "amount" => [
                        "currency" => $currency,
                        "subunits" => (int) ($amount * 100)
                    ],
                    "bank_account_name" => str_replace(" ", "_", strtolower($record[self::BANK_ACCOUNT_NAME_INDEX])),
                    "bank_account_number" => $bank_account_number,
                    "bank_branch_code" => $bank_branch_code,
                    "bank_code" => $record[self::BANK_CODE_INDEX],
                    "end_to_end_id" => $end_to_end_id,
                ];
			}
        }
        fclose($document);
        return [
            "filename" => basename($file),
            "failure_code" => $failure_code,
            "failure_message" => $failure_message,
            "records" => $records
        ];
    }
}

?>
