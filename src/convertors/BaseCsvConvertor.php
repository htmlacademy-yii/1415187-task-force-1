<?php

namespace M2rk\Taskforce\convertors;

use Exception;
use SplFileObject;

class BaseCsvConvertor
{
    /**
     * численный тип данных
     */
    public const TYPE_INT = 'int';

    /**
     * строковый тип данных
     */
    public const TYPE_STRING = 'string';

    /**
     * @var string $file_CSV имя и путь к файлу формата CSV
     */
    private string $file_CSV;

    /**
     * @var string $file_import имя и путь к файлу с инструкцией для записи в БД (результат импорта данных)
     */
    private string $file_import;

    /**
     * @var string $table_SQL имя таблицы БД, в которую будут записаны данные
     */
    private string $table_SQL;

    /**
     * @var array $columns массив, каждый элемент которого ассоциативный массив,
     * где ключ - имя поля таблицы БД, в которую будут добавляться данные, а значение - тип данных
     * Пример: [['email'=>'string'], ['login'=>'string'], ['city_id'=>'int']]
     */
    private array $columns;

    /**
     * @var SplFileObject $file_object объект класса SplFileObject
     */
    private SplFileObject $file_object;

    /**
     * @var array $result массив для хранения результата импорта
     */
    private $result = [];

    public function __construct(string $file_CSV, string $table_SQL, array $columns)
    {
        $this->file_CSV = $file_CSV;
        $this->table_SQL = $table_SQL;
        $this->columns = $columns;
    }

    /**
     * Импорт данных и их запись в текстовый файл с инструкцией SQL
     *
     * @param string $file_name Путь и имя файла для записи
     * @return bool
     * @throws Exception
     */
    public function import(string $file_name): bool
    {
        if (!file_exists($this->file_CSV)) {
            throw new Exception("Файл не существует");
        }

        try {
            $this->file_object = new \SplFileObject($this->file_CSV);
        } catch (\RuntimeException $exception) {
            throw new Exception("Не удалось открыть файл на чтение");
        }

        $header_data = $this->getHeaderData();

        if (count($header_data) !== count($this->columns)) {
            throw new Exception("Количество столбцов в исходном файле не соответствует заданным параметрам");
        }

        foreach ($this->getNextLine() as $line) {
            $this->result[] = $line;
        }

        $this->result = array_filter(
            $this->result,
            function ($arr) {
                return !is_null($arr[0]);
            }
        );

        $this->file_import = $file_name;

        return $this->writeSQL();
    }

    /**
     * Запись строки с инструкцией SQL в файл
     *
     * @return bool
     * @throws Exception
     */
    private function writeSQL(): bool
    {
        try {
            $file = new \SplFileObject($this->file_import, 'w');
        } catch (\RuntimeException $exception) {
            throw new Exception("Не удалось создать файл для записи");
        }

        $result = $file->fwrite($this->getSQL());

        return !!$result;
    }

    /**
     * Формирование строки с инструкцией SQL
     *
     * @return string
     */
    private function getSQL(): string
    {
        return "INSERT " . $this->table_SQL . "(" . $this->getColumns() . ")" . " VALUES " . $this->getData() . ";";
    }

    /**
     * Получение первой строки файла CSV (заголовки столбцов)
     *
     * @return array|null
     */
    private function getHeaderData(): ?array
    {
        $this->file_object->rewind();
        $data = $this->file_object->fgetcsv();

        return $data;
    }

    /**
     * Получение текущей строки файла CSV
     *
     * @return iterable|null
     */
    private function getNextLine(): ?iterable
    {
        $result = null;
        while (!$this->file_object->eof()) {
            yield $this->file_object->fgetcsv();
        }
        return $result;
    }

    /**
     * Формирование строки с перечнем колонок таблицы БД, в которые будут добавлены данные
     *
     * @return string
     */
    private function getColumns(): string
    {
        $result = array_reduce(
            $this->columns,
            function ($carry, $item) {
                return $carry . key($item) . ', ';
            }
        );

        return mb_substr($result, 0, mb_strlen($result) - 2);
    }

    /**
     * Формирование строки с данными для добавления в таблицу БД
     *
     * @return string
     */
    private function getData(): string
    {
        $result = array_reduce(
            $this->result,
            function ($carry, $item) {
                return $carry . '(' . $this->getCSV($item) . '), ';
            }
        );

        return mb_substr($result, 0, mb_strlen($result) - 2);
    }

    /**
     * Формирование части строки с данными для добавления в таблицу БД
     *
     * @param array $arr текущий элемент массива $this->result (результат работы метода import)
     * @return string
     */
    private function getCSV(array $arr): string
    {
        $counter = 0;
        $result = array_reduce(
            $arr,
            function ($carry, $item) use (&$counter) {
                $type = current($this->columns[$counter]);
                $counter += 1;
                switch ($type) {
                    case self::TYPE_INT:
                        return $carry . $item . ",";
                    default:
                        return $carry . "'" . addslashes($item) . "',";
                }
            }
        );

        return mb_substr($result, 0, mb_strlen($result) - 1);
    }
}
