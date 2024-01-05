<?php

class CsvReader
{
    private $file;

    public function __construct(string $filepath)
    {
        $this->file = fopen($filepath, 'r');
    }

    public function readRow(): void
    {
        $idx = 0;
        while (!feof($this->file)) {
            ++$idx;

            $row = fgetcsv($this->file, 4096);

            // show progress
            if ($idx > 0 && $idx % 1000000 === 0) {
                echo $idx / 1000000 . 'M: ' . memory_get_usage() / 1024 . ' kb' .  PHP_EOL;
            }

            // get 100 rows right after 30 millions skipped
            if ($idx < 30000000) {
                continue;
            } elseif ($idx > 30000100) {
                break;
            }

            [$year, $age, $ethnic, $sex, $area, $count] = $row;

            echo "{$year}, {$area}, {$sex}, {$count}" . PHP_EOL;
        }
        fclose($this->file);
    }
}

$csv = new CsvReader('./data/Data8277.csv');
$csv->readRow();
