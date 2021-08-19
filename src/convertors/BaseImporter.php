<?php

namespace M2rk\Taskforce\convertors;

use M2rk\Taskforce\exceptions\CsvBaseException;
use SplFileObject;

class BaseImporter
{
    /**
     * @var string
     */
    private string $fileName;

    /**
     * @var array
     */
    private array $columns;

    /**
     * @var string
     */
    private string $tableName;

    /**
     * @var array
     */
    private array $header;

    /**
     * @var array
     */
    private array $result = [];

    public function __construct(string $fileName, string $tableName, array $columns)
    {
        $this->fileName = $fileName;
        $this->columns = $columns;
        $this->tableName = $tableName;
    }

    /**
     * @throws CsvBaseException
     */
    public function readFile(): array
    {
        if (!file_exists($this->fileName)) {
            throw new CsvBaseException('Файл не существует');
        }

        $readFileObject = new SplFileObject($this->fileName);
        $readFileObject->setFlags(SplFileObject::SKIP_EMPTY | SplFileObject::READ_AHEAD);
        $this->header = $readFileObject->fgetcsv();

        while (!$readFileObject->eof()) {
            $this->result[] = str_replace(PHP_EOL . PHP_EOL, ' ', $readFileObject->fgetcsv());
        }

        return array_filter($this->result);
    }

    /**
     * @throws CsvBaseException
     */
    public function import(): void
    {
        $this->result = $this->readFile();
        $writeFileObject = new SplFileObject($this->fileName . ".sql", "a+");
        $randCount = count($this->columns) - count($this->header);
        $stringColumn = implode(", ", $this->columns);
        $writeFileObject->fwrite('USE taskforce;' . PHP_EOL);
        $writeFileObject->fwrite("INSERT INTO $this->tableName ($stringColumn) VALUES\r\n");

        foreach ($this->result as $key => $row) {
            if (count($row) !== count($this->header)) {
                continue;
            }

            $stringRow = "('" . implode("', '", $row) . "'";

            if ($randCount) {
                for ($i = 0; $i < $randCount; $i++) {
                    $rand = rand(1, 6);
                    $stringRow .= ", '$rand'";
                }
            }

            $stringRow .= "),\r\n";

            if ($key === array_key_last($this->result)) {
                $stringRow = substr_replace($stringRow, ';', -3);
            }

            $writeFileObject->fwrite($stringRow);
        }
    }
}
