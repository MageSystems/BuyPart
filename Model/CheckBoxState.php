<?php declare(strict_types=1);

namespace MageSystems\BuyPart\Model;

use Magento\Framework\App\ResourceConnection;

class CheckBoxState
{
    public const PARAM_NAME = 'selected_items';

    public const FIELD_NAME = 'ms_checked';

    protected ResourceConnection $resource;

    public function __construct(ResourceConnection $resource)
    {
        $this->resource = $resource;
    }

    public function setStateForQuoteItem($cartId, array $selectedItems)
    {
        $this->checkAllCheckBoxes($cartId);
        $this->checkItems($selectedItems);
    }

    public function checkAllCheckBoxes($cartId)
    {
        $tableName = $this->resource->getTableName('quote_item');

        $sql = "UPDATE $tableName SET ms_checked = 1 WHERE quote_id = {$cartId}";
        $this->resource->getConnection()->query($sql);
    }

    public function checkItems(array $selectedItems)
    {
        $tableName = $this->resource->getTableName('quote_item');
        $selectedItems = $this->processSelectedItems($selectedItems);
        $sql = "UPDATE $tableName SET ms_checked = 0 WHERE item_id IN ($selectedItems)";
        $this->resource->getConnection()->query($sql);
    }

    private function processSelectedItems($selectedItems)
    {
        return \implode(',', $selectedItems);
    }


}
