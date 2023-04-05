<?php

class FinalResult {
    function results($file) {
		$fileContents = array_map("str_getcsv", file($file));
        [$currency, $failure_code, $failure_message] = $fileContents[0];
        $records = [];
        foreach ($fileContents as $record):
			if (count($record) == 16) {
                $amt = !$record[8] || $record[8] === "0" ? 0 : (float) $record[8];
                $ban = !$record[6] ? "Bank account number missing" : (int) $record[6];
                $bac = !$record[2] ? "Bank branch code missing" : $record[2];
                $e2e = !$record[10] && !$record[11] ? "End to end id missing" : $record[10] . $record[11];
                $records[] = [
                    "amount" => [
                        "currency" => $currency,
                        "subunits" => (int) ($amt * 100)
                    ],
                    "bank_account_name" => str_replace(" ", "_", strtolower($record[7])),
                    "bank_account_number" => $ban,
                    "bank_branch_code" => $bac,
                    "bank_code" => $record[0],
                    "end_to_end_id" => $e2e,
                ];
			}
		endforeach;
        return [
            "filename" => basename($file),
            "failure_code" => $failure_code,
            "failure_message" => $failure_message,
            "records" => $records
        ];
    }
}

?>
