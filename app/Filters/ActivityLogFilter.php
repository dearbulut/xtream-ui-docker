<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ActivityLogFilter
{
    protected $request;
    protected $builder;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        foreach ($this->filters() as $name => $value) {
            if (method_exists($this, $name)) {
                call_user_func_array([$this, $name], array_filter([$value]));
            }
        }

        return $this->builder;
    }

    public function filters()
    {
        return array_filter($this->request->only([
            'search',
            'type',
            'user',
            'from_date',
            'to_date',
        ]));
    }

    protected function search($search)
    {
        $this->builder->search($search);
    }

    protected function type($type)
    {
        $this->builder->ofType($type);
    }

    protected function user($userId)
    {
        $this->builder->byUser($userId);
    }

    protected function from_date($date)
    {
        if ($this->request->to_date) {
            $this->builder->inDateRange($date, $this->request->to_date);
        } else {
            $this->builder->whereDate('created_at', '>=', $date);
        }
    }

    protected function to_date($date)
    {
        if (!$this->request->from_date) {
            $this->builder->whereDate('created_at', '<=', $date);
        }
    }
}