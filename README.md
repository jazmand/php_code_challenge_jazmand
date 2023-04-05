# Simple code challenge improvement details #

Below are changes I deemed as improvements to the FinalResult.php file provided from the original repository, with explanations as to why they were done.

|   Original   |   Improvement  |   Explanation |
|     :---:    |     :---:      |     :---     |
| `$f`    | `$file`     | clearer variable name      |
| `fopen()`   | `file()`     | Instead of keeping the file open to look at the file line by line, get the content all at once   |
| `fgetcsv`   | `str_getcsv` and `array_map()`      | since we have the data from file(),  we can get each item from each line and store it in $fileContents as an array    |
|  `$h`      | `[$currency, $failure_code, $failure_message] = $fileContents[0];`      | instead of the variable $h containing the data and targeting the failure_code and failure_message by their indices, just assign them to clearer variables at once on one line   |
| `$rcs`    | `$records `     | clearer variable name      |
| `while() `   | `foreach() `     | we can utilize foreach() to loop through the entire array and stop once it reaches the end  |
|    |    |     |
|   `$rcs[] = $rcd;` |   removed  |  the creation of the $rcd variable is not needed as the array assigned to $rcd can be directly pushed to $rcs/$records |
| `$rcs = array_filter($rcs);`   | removed      | filtering the array does not have any purpose as we are already checking if each line has the necessary 16 items   |
| `"document" => $d `    | removed       | Since the test file does not expect "document" to be in the return value, it was deemed unnecessary



