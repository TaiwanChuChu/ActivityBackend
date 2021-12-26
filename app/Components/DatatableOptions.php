<?php

namespace App\Components;

use Illuminate\Support\Collection;

class DatatableOptions
{

    /*
     *  "page" => 1
      "itemsPerPage" => 10
      "sortBy" => array:3 [
        0 => "type_code"
        1 => "type_name"
        2 => "state"
      ]
      "sortDesc" => array:3 [
        0 => true
        1 => true
        2 => true
      ]
      "groupBy" => []
      "groupDesc" => []
      "mustSort" => false
      "multiSort" => true
     * */

    private $_sortDesc; // 排序方式

    private $_sortBy; // 排序欄位

    private $_itemsPerPage; // 每頁筆數

    private $_page; // 頁數

    public function __construct(array $options)
    {
        tap(collect($options), function ($options) {
            $this->_page = $options->get('page', 0);
            $this->_itemsPerPage = $options->get('itemsPerPage', 0);
            $this->_sortBy = $options->get('sortBy');
            $this->_sortDesc = $options->get('sortDesc');
        });

    }

    /**
     * @return mixed
     */
    public function getSortDesc()
    {
        return $this->_sortDesc;
    }

    /**
     * @return mixed
     */
    public function getSortBy()
    {
        return $this->_sortBy;
    }

    /**
     * @return mixed
     */
    public function getItemsPerPage()
    {
        return $this->_itemsPerPage;
    }

    /**
     * @return mixed
     */
    public function getPage()
    {
        return $this->_page;
    }
}
