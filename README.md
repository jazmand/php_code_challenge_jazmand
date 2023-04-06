# Simple code challenge improvement details #

Below are changes I deemed as improvements to the FinalResult.php file provided from the original repository, with explanations as to why they were done.

|   Original   |   Improvement  |   Explanation |
|     :---:    |     :---:      |     :---     |
|   not present |  `const EXPECTED_RECORD_LENGTH = 16;`  |   It is not immediately clear what the number 16 means, so it is better to define a constant to let the reader clearly know what it is   |
| `$f`    | `$file`     | clearer variable name      |
| `$d`    | `$document`     | clearer variable name      |
| `fopen()`   | unchanged     | Initially, this was changed to `file()`, but given that multiple files of unknown sizes could hypothtically be read, it was decided that `fopen` would be better in real-life scenarios to avoid memory issues  |
| `fgetcsv`   | unchanged      | Initially, this was changed to `str_getcsv` and `array_map()` but since we are using `fopen()` this was kept to avoid potential memory issues on potential real-life larger files    |
|  `$h = fgetcsv($d);`      | `[$currency, $failure_code, $failure_message] = fgetcsv($document);`      | instead of the variable $h containing the data and targeting the failure_code and failure_message by their indices, just assign them to clearer variables at once on one line   |
| `$rcs`    | `$records `     | clearer variable name      |
| `while(!feof($d))`   | `while(($record = fgetcsv($document)) !== false)` |  Using this approach ensures that all lines of the file are read and processed correctly, without the risk of data loss or errors caused by feof() returning true before the last line.  |
|   `$rcs[] = $rcd;` |   removed  |  the creation of the $rcd variable is not needed as the array assigned to $rcd can be directly pushed to $rcs/$records |
| `$rcs = array_filter($rcs);`   | removed      | filtering the array does not have any purpose as we are already checking if each line has the necessary 16 items   |
| not present    | `fclose($document);`     | It's important to ensure the document previously opened is closed, as multiple files may be opened and read, we should free up system resources to avoid potential issues, data inconsistencies, and/or corruption   |
| `"document" => $d/$document `    | unchanged       | Since the test file does not expect "document" to be in the return value, it was deemed unnecessary and closed using `fclose()` as stated above 
|    |    |     |


