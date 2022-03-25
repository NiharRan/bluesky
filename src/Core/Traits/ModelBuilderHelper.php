<?php

namespace Bluesky\Core\Traits;

use Bluesky\Core\Facades\Model;

trait ModelBuilderHelper
{
    public function generateField(array $params, $condition = 'AND'): void
    {
        $size = count($params);
        if ($size == 2) {
            $this->whereBlocks[] = [$condition, $params[0], '=', $params[1]];
        }

        if ($size == 3) {
            $this->whereBlocks[] = [$condition, $params[0], $params[1], $params[2]];
        }
    }

    public function buildQuery(): void
    {
        $table = $this->table;
        $selectSql = $this->generateSelectSql();
        $this->sqlQuery = "SELECT $selectSql FROM $table";
        if (count($this->whereBlocks) > 0) {
            $this->generateWhereBlocks();
        }
    }

    private function generateSelectSql()
    {
        if (count($this->selects) > 0) {
            return implode(',', $this->selects);
        }
        return "*";
    }

    private function generateWhereBlocks()
    {
        $subBlockStarts = false;
        $this->sqlQuery .= " WHERE";
        foreach ($this->whereBlocks as $key => $block) {
            if ($block[1] == '(') {
                $subBlockStarts = true;
                $this->sqlQuery .= " " . $block[0] . " " . $block[1];
            } elseif ($block[3] == ')') {
                $this->sqlQuery .= " " . $block[3];
            } else {
                if ($key == 0) {
                    $this->sqlQuery .= " " . $block[1] . " " . strtoupper($block[2]) . "'" . $block[3] . "'";
                } else {
                    $subBlock = " " . $block[0];
                    if ($subBlockStarts) {
                        $subBlock = "";
                        $subBlockStarts = false;
                    }
                    $this->sqlQuery .= $subBlock . " " . $block[1] . " " . strtoupper($block[2]) . "'" . $block[3] . "'";
                }
            }
        }
    }
}
