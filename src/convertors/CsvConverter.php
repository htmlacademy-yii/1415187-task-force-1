<?php

namespace M2rk\Taskforce\convertors;

use SplFileObject;

class CsvConverter
{
    private array $fileParams = [];

    public function __construct(string $filePath)
    {
        $this->fileParams['first_row'] = true;
        $this->fileParams['file_name'] = pathinfo($filePath)['filename'];
        $this->fileParams['file_dir'] = pathinfo($filePath)['dirname'];
    }

    private function getHeader(): array
    {
        $this->fileParams['file_input']->rewind();

        return $this->fileParams['file_input']->current();
    }

    private function getData(): iterable
    {
        while (!$this->fileParams['file_input']->eof()) {
            yield $this->fileParams['file_input']->fgetcsv();
            $this->fileParams['first_row'] = false;
        }
    }

    private function writeData(SplFileObject $file, array $values): void
    {
        if ($values[0]) {
            $values = '"' . implode('","', $values) . '"';
            $string = "\n($values)";

            if (!$this->fileParams['first_row']) {
                $string = substr_replace($string, ',', 0, 0);
            }

            $file->fwrite($string);
        }
    }

    private function writeHeader(SplFileObject $file, array $headers): void
    {
        $headers = '`' . implode('`,`', $headers) . '`';
        $string = "INSERT INTO `taskforce`.`{$this->fileParams['file_name']}` ($headers)\nVALUES";
        $file->fwrite($string);
    }

    public function convert(): void
    {
        $this->fileParams['file_input'] = new SplFileObject(
            $this->fileParams['file_dir'] . '/' . $this->fileParams['file_name'] . '.csv'
        );
        $this->fileParams['file_input']->setFlags(SplFileObject::READ_CSV);

        $this->fileParams['file_output'] = new SplFileObject(
            $this->fileParams['file_dir'] . '/' . $this->fileParams['file_name'] . '.sql', 'w'
        );
        $this->writeHeader($this->fileParams['file_output'], $this->getHeader());

        foreach ($this->getData() as $values) {
            $this->writeData($this->fileParams['file_output'], $values);
        }
    }
}
