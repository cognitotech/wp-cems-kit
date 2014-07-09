<?php
/**
 * Created by PhpStorm.
 * User: pnghai
 * Date: 7/9/14
 * Time: 1:09 PM
 */
/**
 * Model of a single CEMSPreviewEbook template
 *
 * @class           CEMSPreviewEbook
 * @author          pnghai <nguyenhai@siliconstraits.vn>
 * @copyright       Copyright (C) 2014-2015 Silicon Straits. All Rights Reserved.
 * @date            2014-07-15
 * @version         1.0.0
 *
 */
class CEMSPreviewEbook {

    /**
     * List ID
     *
     * @brief List ID
     *
     * @var int $list_id
     */
    public $list_id = -1;

    /**
     * Book Title
     *
     * @brief Book Title
     *
     * @var int $book_title
     */
    public $book_title = '';

    /**
     * Create an instance of CEMSPreviewEbook class
     *
     * @brief Construct
     *
     * @param array Required Shortcode Attributes
     *
     * @return CEMSPreviewEbook
     */
    public function __construct( $attributes)
    {
        extract($attributes);
        if ( !empty( $list_id ) ) {
            $this->list_id=$list_id;
        }
        if ( !empty( $book_title ) ) {
            $this->book_title=$book_title;
        }
    }

    /**
     * Display preview button
     *
     * @brief Display
     */
    public function display()
    {
        echo $this->html();
    }

    /**
     * Return the HTML markup for the preview button
     *
     * @brief HTML markup preview button
     *
     * @return string
     */
    public function html()
    {
        WPDKHTML::startCompress();
        //#TODO: Bootstrap things come with CEMSTheme should only loaded here
        ?>
        <div class="panel panel-default">
            <div class="panel-body">
                <div id="ebook-subscription" class="collapse">
                    <p>Bạn đã đăng ký email để tải thông tin trên trang TGM Books chưa?</p>
                    <div class="panel-group" id="cems-accordion1">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#cems-accordion1" href="#collapseSubscriptionForm">
                                        <?php echo __('Tôi đã đăng ký email',WPCEMS_TEXTDOMAIN);?>
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseSubscriptionForm" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <?php echo __('Vui lòng nhập lại địa chỉ email bạn đã đăng ký',WPCEMS_TEXTDOMAIN);?>
                                    <form role="form" class="form-inline" name="subscription-form" id="subscription-form" method="post" >
                                        <div class="form-group">
                                            <label for="subscription-email"><?php echo __('
Địa chỉ email của bạn:',WPCEMS_TEXTDOMAIN);?><sup>*</sup></label>
                                            <input type="email" class="form-control" id="subscription-email" name="subscriptionEmail" placeholder="<?php echo __('Nhập địa chỉ email',WPCEMS_TEXTDOMAIN);?>" required>
                                            <input type="hidden" class="hidden" name="listId" value="<?php echo $this->list_id;?>"/>
                                        </div>
                                        <button data-loading-text="Đang gửi ..." type="submit" class="btn btn-primary" id="btn-new-subscription"><?php echo __('Xác nhận',WPCEMS_TEXTDOMAIN);?></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#cems-accordion1" href="#collapseCustomerForm">
                                        <?php echo __('Tôi chưa đăng ký email',WPCEMS_TEXTDOMAIN);?>
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseCustomerForm" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <form role="form" name="customer-form" id='customer-form' method="post">
                                        <div class="form-group">
                                            <label for="customer-email"><?php echo __('
Địa chỉ email của bạn:',WPCEMS_TEXTDOMAIN);?></label>
                                            <input type="email" class="form-control" id="customer-email" name="customer-email" placeholder="<?php echo __('Nhập địa chỉ email',WPCEMS_TEXTDOMAIN);?>" required>
                                        </div>
                                        <button data-loading-text="Đang gửi ..." type="submit" class="btn btn-primary" id="btn-new-customer"><?php echo __('Xác nhận',WPCEMS_TEXTDOMAIN);?></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#ebook-subscription">
                    Tải về và đọc thử sách <?php echo $this->book_title;?> (giống sách in 100%)
                </button>
            </div>
        </div>
        <?php
        $content = WPDKHTML::endHTMLCompress();
        return $content;
    }
}