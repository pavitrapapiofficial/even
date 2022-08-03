<?php
namespace PurpleCommerce\CustomPDFButton\Plugin\Block\Adminhtml\Order\Invoice;

class View {

public function beforeSetLayout(\Magento\Sales\Block\Adminhtml\Order\Invoice\View $view)
{
    $message ='Are you sure you want to do this?';
    $invoId = time().'#'.$view->getInvoice()->getId();
    $url = '/pdfinvoice?id=' . base64_encode($invoId);
    

    $view->addButton(
        'order_myaction',
        [
            'label' => __('GST Invoice'),
            'class' => 'myclass',
            'target' => '_blank',
            'onclick' => 'setTimeout(function(){ location.reload(); }, 1000);window.open(\'' . $url . '\')'
        ]
    );
    


}
}
