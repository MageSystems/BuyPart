<?php declare(strict_types=1);

namespace MageSystems\BuyPart\Plugin;

use Magento\Checkout\Api\Data\TotalsInformationInterface;
use Magento\Checkout\Model\TotalsInformationManagement;
use Magento\Framework\App\RequestInterface;
use MageSystems\BuyPart\Model\CheckBoxState;

class SaveCheckboxState
{
    protected RequestInterface $request;
    protected CheckBoxState $checkBoxState;

    public function __construct(RequestInterface $request, CheckBoxState $checkBoxState)
    {
        $this->request = $request;
        $this->checkBoxState = $checkBoxState;
    }

    public function beforeCalculate(
        TotalsInformationManagement $subject,
        int $cartId,
        TotalsInformationInterface $addressInformation
    ) {
        $selectedItems = $this->request->getParam(CheckBoxState::PARAM_NAME);
        if(!$selectedItems){
            $this->checkBoxState->checkAllCheckBoxes($cartId);
            return [$cartId, $addressInformation];
        }
        $this->checkBoxState->setStateForQuoteItem($cartId, $selectedItems);

        return [$cartId, $addressInformation];
    }
}
