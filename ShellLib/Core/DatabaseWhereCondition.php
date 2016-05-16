<?php

class DatabaseWhereCondition
{
    public $Operator;
    public $Operands;

    public function __construct($operandArray, $operator = 'AND')
    {
        $this->Operator = $operator;
        $this->Operands = $operandArray;
    }

    public function GetWhereClause()
    {
        $whereClauses = array();
        $parameters = array();

        if($this->Operator == 'AND' || $this->Operator == 'OR') {
            foreach ($this->Operands as $key => $value) {
                if (is_a($value, 'DatabaseWhereCondition')) {
                    $subWhereClause = $value->GetWhereClause();
                    $whereClauses[] = $subWhereClause['ConditionString'];

                    foreach ($subWhereClause['Parameters'] as $parameter) {
                        $parameters[] = $parameter;
                    }
                } else if ($value === null) {
                    $whereClauses[] = "$key is null";
                } else {
                    $whereClauses[] = "$key = ?";
                    $parameters[] = $value;
                }
            }

            if ($this->Operator == 'AND') {
                $conditionString = '(' . implode(' AND ', $whereClauses) . ')';
            } else if ($this->Operator == 'OR') {
                $conditionString = '(' . implode(' OR ', $whereClauses) . ')';
            } else {
                $conditionString = "";
            }

        }else if($this->Operator == 'LIKE') {
            $keys = array_keys($this->Operands);
            $field = $keys[0];
            $conditionString = "( $field  LIKE ?)";
            $parameters[] = '%' . $this->Operands[$field] . '%';
        }

        return array(
            'ConditionString' => $conditionString,
            'Parameters' => $parameters
        );
    }
}

// Short hand functions to create new where conditions with less code and the desired result to show more intent
function AndCondition($operands)
{
    return new DatabaseWhereCondition($operands, 'AND');
}

function OrCondition($operands)
{
    return new DatabaseWhereCondition($operands, 'OR');
}

function LikeCondition($field, $value)
{
    return new DatabaseWhereCondition(array($field => $value), 'LIKE');
}