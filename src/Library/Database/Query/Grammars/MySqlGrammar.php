<?php

namespace CloudyCity\LaravelBuilderMacros\Library\Database\Query\Grammars;

use Illuminate\Database\Query\Grammars\MySqlGrammar as Grammar;
use CloudyCity\LaravelBuilderMacros\Library\Database\Query\MySqlBuilder as Builder;

class MySqlGrammar extends Grammar
{
    /**
     * Compile a replace into statement into SQL.
     *
     * @link https://dev.mysql.com/doc/refman/5.5/en/replace.html
     *
     * @param \CloudyCity\LaravelBuilderMacros\Library\Database\Query\MySqlBuilder $query
     * @param array $data
     * @return string
     */
    public function compileReplace(Builder $query, array $data)
    {
        // Essentially we will force every insert to be treated as a batch insert which
        // simply makes creating the SQL easier for us since we can utilize the same
        // basic routine regardless of an amount of records given to us to insert.
        $table = $this->wrapTable($query->from);

        if (!is_array(reset($data))) {
            $data = [$data];
        }

        $columns = $this->columnize(array_keys(reset($data)));

        // We need to build a list of parameter place-holders of values that are bound
        // to the query. Each insert should have the exact same amount of parameter
        // bindings so we will loop through the record and parameterize them all.
        $values = [];

        foreach ($data as $record) {
            $values[] = '(' . $this->parameterize($record) . ')';
        }

        $values = implode(', ', $values);

        return "REPLACE INTO {$table} ({$columns}) VALUES {$values}";
    }

    /**
     * Compile an insert ignore statement into SQL.
     *
     * @link https://dev.mysql.com/doc/refman/5.5/en/insert.html
     *
     * @param \CloudyCity\LaravelBuilderMacros\Library\Database\Query\MySqlBuilder $query
     * @param array $data
     * @return string
     */
    public function compileInsertIgnore(Builder $query, array $data)
    {
        // Essentially we will force every insert to be treated as a batch insert which
        // simply makes creating the SQL easier for us since we can utilize the same
        // basic routine regardless of an amount of records given to us to insert.
        $table = $this->wrapTable($query->from);

        if (!is_array(reset($data))) {
            $data = [$data];
        }

        $columns = $this->columnize(array_keys(reset($data)));

        // We need to build a list of parameter place-holders of values that are bound
        // to the query. Each insert should have the exact same amount of parameter
        // bindings so we will loop through the record and parameterize them all.
        $values = [];

        foreach ($data as $record) {
            $values[] = '(' . $this->parameterize($record) . ')';
        }

        $values = implode(', ', $values);

        return "INSERT IGNORE INTO {$table} ({$columns}) VALUES {$values}";
    }

    /**
     * Compile an insert update statement into SQL.
     *
     * @link https://dev.mysql.com/doc/refman/8.0/en/insert-on-duplicate.html
     * @link https://gist.github.com/RuGa/5354e44883c7651fd15c
     *
     * @param \CloudyCity\LaravelBuilderMacros\Library\Database\Query\MySqlBuilder $query
     * @param array $data
     * @return string
     */
    public function compileInsertUpdate(Builder $query, array $data)
    {
        // Essentially we will force every insert to be treated as a batch insert which
        // simply makes creating the SQL easier for us since we can utilize the same
        // basic routine regardless of an amount of records given to us to insert.
        $table = $this->wrapTable($query->from);

        $columnNames = array_keys(reset($data));

        $columns = $this->columnize($columnNames);

        $values = implode(',', array_map(function ($row) {
            return '(' . $this->parameterize($row) . ')';
        }, $data));

        $updates = implode(',', array_map(function ($columnName) {
            return $this->wrap($columnName) . ' = VALUES(' . $this->wrap($columnName) . ')';
        }, $columnNames));

        return "INSERT INTO {$table} ({$columns}) VALUES {$values} ON DUPLICATE KEY UPDATE {$updates}";
    }
}
