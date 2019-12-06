<?php

namespace CloudyCity\LaravelBuilderMacros\Library\Database;

use CloudyCity\LaravelBuilderMacros\Library\Database\Query\Grammars\MySqlGrammar as QueryGrammar;
use CloudyCity\LaravelBuilderMacros\Library\Database\Query\MySqlBuilder as Builder;
use Illuminate\Database\MySqlConnection as Connection;
use Illuminate\Database\Query\Processors\MySqlProcessor as Processor;

class MySqlConnection extends Connection
{
    /**
     * Get the default query grammar instance.
     *
     * @return \Illuminate\Database\Grammar|\Illuminate\Database\Query\Grammars\MySqlGrammar
     */
    protected function getDefaultQueryGrammar()
    {
        return $this->withTablePrefix(new QueryGrammar);
    }

    /**
     * @return Processor
     */
    protected function getDefaultPostProcessor()
    {
        return new Processor;
    }

    /**
     * Get a new query builder instance.
     *
     * @return \CloudyCity\LaravelBuilderMacros\Library\Database\Query\MySqlBuilder
     */
    public function query()
    {
        return new Builder(
            $this,
            $this->getQueryGrammar(),
            $this->getPostProcessor()
        );
    }
}
