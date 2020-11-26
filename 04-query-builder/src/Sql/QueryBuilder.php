<?php

namespace App\Sql;

class QueryBuilder
{
    protected string $from;
    protected string $select = '';
    protected string $where = '';
    protected string $limit = '';

    public function __construct(string $table)
    {
        $this->from = " FROM " . $table;
    }

    public function getQuery(): string
    {
        $this->select = $this->select ? $this->select : 'SELECT *';

        return $this->select
            . $this->from
            . $this->where
            . $this->limit;
    }

    public function select(string $select): QueryBuilder
    {
        $this->select = 'SELECT ' . $select;
        return $this;
    }

    public function addSelect(string $select): QueryBuilder
    {

        if (!$this->select) {
            $this->select($select);
        } else {
            $select = $select[0] != ',' ? ', ' . $select : $select;
            $this->select .= $select;
        }

        return $this;
    }

    public function where(string $where): QueryBuilder
    {
        $this->where = " WHERE " . $where;
        return $this;
    }

    public function limit(int $limit): QueryBuilder
    {
        $this->limit = " LIMIT " . $limit;
        return $this;
    }
}