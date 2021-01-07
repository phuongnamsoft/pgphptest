<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

abstract class BaseModel extends Model {

    const PAGING_LIMIT = 15;
    const PREFIX = '';

    public $guarded = [];
    public $timestamps = FALSE;
    protected $fields = [];

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
    }

    public function getById($id) {
        $result = $this->find($id);
        return $result ? $result->toArray() : array();
    }

    public function getByCond($cond, $orderBy = array()) {
        $query = $this;
        if (!empty($cond)) {
            foreach ($cond as $k => $v) {
                $query = $query->where($k, $v);
            }
        }
        if (is_array($orderBy) && !empty($orderBy)) {
            foreach ($orderBy as $key => $value) {
                $query = $query->orderBy($key, $value);
            }
        }
        return $query->get()->toArray();
    }

    public function countByCond($cond) {
        $query = $this;
        if (!empty($cond)) {
            foreach ($cond as $k => $v) {
                $query = $query->where($k, $v);
            }
        }
        return $query->count();
    }

    public function getRowBy($cond, $orderBy = array()) {
        $query = $this;
        if (!empty($cond)) {
            foreach ($cond as $k => $v) {
                $query = $query->where($k, $v);
            }
        }
        if (is_array($orderBy) && !empty($orderBy)) {
            foreach ($orderBy as $key => $value) {
                $query = $query->orderBy($key, $value);
            }
        }
        $result = $query->first();
        return $result ? $result->toArray() : array();
    }

    public function updateBy($data, $cond = array()) {
        $query = $this;
        if (!empty($cond)) {
            foreach ($cond as $k => $v) {
                $query = $query->where($k, $v);
            }
        }
        return $query->update($data);
    }

    public function updateById($data, $id) {
        return $this->where('id', $id)->update($data);
    }

    public function deleteById($id) {
        return $this->where('id', $id)->delete();
    }

    public function deleteBy($cond = array()) {
        $query = $this;
        if (!empty($cond)) {
            foreach ($cond as $k => $v) {
                $query = $query->where($k, $v);
            }
            return $query->delete();
        }
    }

    public function getWhereIn($field, $inArray) {
        return $this->whereIn($field, $inArray)->get()->toArray();
    }

    public function getWhere($cond) {
        $query = $this;
        if (!empty($cond)) {
            foreach ($cond as $k => $v) {
                $query = $query->where($k, $v);
            }
        }
        return $query->get()->toArray();
    }

    public function getWhereOr($cond) {
        $query = $this;
        if (!empty($cond)) {
            $condCounter = 0;
            foreach ($cond as $k => $v) {
                if ($condCounter == 0) {
                    $query = $query->where($k, $v);
                } else {
                    $query = $query->orWhere($k, $v);
                }
            }
        }
        return $query->get()->toArray();
    }

    public function getPagination($cond = null, $limit = 10, $orderBy = array('id' => 'desc')) {
        $query = $this;
        if (is_array($cond) && !empty($cond)) {
            foreach ($cond as $key => $value) {
                $query = $query->where($key, $value);
            }
        }
        if (is_array($orderBy) && !empty($orderBy)) {
            foreach ($orderBy as $key => $value) {
                $query = $query->orderBy($key, $value);
            }
        }
        return $query->paginate($limit);
    }

    public function getTable() {
        return $this->table;
    }

    public function toggleField($id, $field, $toggleValues = array(0, 1)) {
        $itemDetail = $this->find($id);
        if (!empty($itemDetail)) {
            if ($itemDetail->status == $toggleValues[0]) {
                return $this->where('id', $id)->update(array($field => $toggleValues[1]));
            } else {
                return $this->where('id', $id)->update(array($field => $toggleValues[0]));
            }
        }
    }

    public function checkDuplicate($data, $id, $checkFields = []) {
        $cond = array();
        foreach ($data as $key => $value) {
            if (in_array($key, $checkFields)) {
                $cond[$key] = $value;
            }
        }
        if (!empty($cond)) {
            $results = $this->getWhereOr($cond);
            if (empty($results)) {
                return TRUE;
            } else {
                foreach ($results as $k => $item) {
                    if ($item['id'] == $id) {
                        unset($results[$k]);
                    }
                }
                return empty($results);
            }
        }
        return FALSE;
    }

    public function getTableColumns() {
        return Schema::getColumnListing($this->table);
    }

}
