<?php

namespace CloudyCity\LaravelBuilderMacros\Library\Database\Query;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Query\Builder as QueryBuilder;

class MySqlBuilder extends QueryBuilder
{
    /**
     * The database query grammar instance.
     *
     * @var Grammars\MySqlGrammar
     */
    public $grammar;

    /**
     * Insert a new record into the database, replace on primary key conflict.
     *
     * @param array $values
     * @return bool
     */
    public function replace(array $values)
    {
        if (empty($values)) {
            return true;
        }

        // Since every insert gets treated like a batch insert, we will make sure the
        // bindings are structured in a way that is convenient for building these
        // inserts statements by verifying the elements are actually an array.
        if (! is_array(reset($values))) {
            $values = [$values];
        } else { // Sort the keys in each row alphabetically for consistency
            foreach ($values as $key => $value) {
                ksort($value);
                $values[$key] = $value;
            }
        }

        // We'll treat every insert like a batch insert so we can easily insert each
        // of the records into the database consistently. This will make it much
        // easier on the grammars to just handle one type of record insertion.
        $bindings = [];

        foreach ($values as $record) {
            foreach ($record as $value) {
                $bindings[] = $value;
            }
        }

        $sql = $this->grammar->compileReplace($this, $values);

        // Once we have compiled the insert statement's SQL we can execute it on the
        // connection and return a result as a boolean success indicator as that
        // is the same type of result returned by the raw connection instance.
        $bindings = $this->cleanBindings($bindings);

        return $this->connection->insert($sql, $bindings);
    }

    /**
     * Insert a new record into the database, update on primary key conflict.
     *
     * @param array $values
     * @return bool
     */
    public function insertUpdate(array $values)
    {
        if (empty($values)) {
            return true;
        }

        // Since every insert gets treated like a batch insert, we will make sure the
        // bindings are structured in a way that is convenient for building these
        // inserts statements by verifying the elements are actually an array.
        if (! is_array(reset($values))) {
            $values = [$values];
        } else { // Sort the keys in each row alphabetically for consistency
            foreach ($values as $key => $value) {
                ksort($value);
                $values[$key] = $value;
            }
        }

        // We'll treat every insert like a batch insert so we can easily insert each
        // of the records into the database consistently. This will make it much
        // easier on the grammars to just handle one type of record insertion.
        $bindings = [];

        foreach ($values as $record) {
            foreach ($record as $value) {
                $bindings[] = $value;
            }
        }

        $sql = $this->grammar->compileInsertUpdate($this, $values);

        // Once we have compiled the insert statement's SQL we can execute it on the
        // connection and return a result as a boolean success indicator as that
        // is the same type of result returned by the raw connection instance.
        $bindings = $this->cleanBindings($bindings);

        return $this->connection->insert($sql, $bindings);
    }

    /**
     * Insert a new record into the database, discard on primary key conflict.
     *
     * @param array $values
     * @return bool
     */
    public function insertIgnore(array $values)
    {
        if (empty($values)) {
            return true;
        }

        // Since every insert gets treated like a batch insert, we will make sure the
        // bindings are structured in a way that is convenient for building these
        // inserts statements by verifying the elements are actually an array.
        if (! is_array(reset($values))) {
            $values = [$values];
        } else {
            foreach ($values as $key => $value) {
                ksort($value);
                $values[$key] = $value;
            }
        }

        // We'll treat every insert like a batch insert so we can easily insert each
        // of the records into the database consistently. This will make it much
        // easier on the grammars to just handle one type of record insertion.
        $bindings = [];

        foreach ($values as $record) {
            foreach ($record as $value) {
                $bindings[] = $value;
            }
        }

        $sql = $this->grammar->compileInsertIgnore($this, $values);

        // Once we have compiled the insert statement's SQL we can execute it on the
        // connection and return a result as a boolean success indicator as that
        // is the same type of result returned by the raw connection instance.

        $bindings = $this->cleanBindings($bindings);

        return $this->connection->insert($sql, $bindings);
    }

    /**
     * Add a "where in raw" clause for integer values to the query.
     *
     * @param  string  $column
     * @param  \Illuminate\Contracts\Support\Arrayable|array  $values
     * @param  string  $boolean
     * @param  bool  $not
     * @return \Illuminate\Database\Query\Builder
     */
    public function whereIntegerInRaw($column, $values, $boolean = 'and', $not = false)
    {
        $type = $not ? 'NotInRaw' : 'InRaw';

        if ($values instanceof Arrayable) {
            $values = $values->toArray();
        }

        foreach ($values as &$value) {
            $value = (int) $value;
        }

        $this->wheres[] = compact('type', 'column', 'values', 'boolean');

        return $this;
    }
}
