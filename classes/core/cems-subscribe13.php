<?php
/**
 * Created by PhpStorm.
 * User: pnghai
 * Date: 7/9/14
 * Time: 1:09 PM
 */
/**
 * Model of a single CEMSSubscribeForm13 template
 *
 * @class           CEMSSubscribeForm13
 * @author          pnghai <nguyenhai@siliconstraits.vn>
 * @copyright       Copyright (C) 2014-2015 Silicon Straits. All Rights Reserved.
 * @date            2014-10-15
 * @version         1.0.0
 *
 */
class CEMSSubscribeForm13 {

    /**
     * Event ID
     *
     * @brief Event ID
     *
     * @var int $list_id
     */
    public $list_id = -1;

    /**
     * Create an instance of CEMSSubscribeForm13 class
     *
     * @brief Construct
     *
     * @param array $attributes Required Shortcode Attributes
     *
     * @return CEMSSubscribeForm13
     */
    public function __construct( $attributes)
    {
        extract($attributes);
        if ( !empty( $id ) ) {
            $this->list_id = $id;
        }
    }

    /**
     * Display event form
     *
     * @brief Display
     */
    public function display()
    {
        echo $this->html();
    }

    /**
     * Return the HTML markup for the event form
     *
     * @brief HTML markup event form
     *
     * @return string
     */
    public function html()
    {
        WPDKHTML::startCompress();
        ?>
        <div class="panel panel-default cems-subscribe13-panel">
            <div class="panel-body">
                <form role="form" name="subscribe13-form" id='subscribe13-form' method="post" class='subscriptionForm' data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
                      data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
                      data-bv-feedbackicons-validating="glyphicon glyphicon-refresh">
                    <input type="hidden" value="<?php echo $this->list_id;?>" name="subscription[subscriber_list_id]">
                    <input type="hidden"  name="subscription[customer_source]">

                    <div class="form-group">
                        <input type="email" class="form-control" name="customer[email]" placeholder="<?php echo __('Địa chỉ email của bạn',WPCEMS_TEXTDOMAIN);?>" data-bv-notempty="true"
                               data-bv-notempty-message="Bạn cần điền email"

                               data-bv-emailaddress="true"
                               data-bv-emailaddress-message="Email không hợp lệ">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="customer[fullname]" placeholder="<?php echo __('Họ tên',WPCEMS_TEXTDOMAIN);?>" data-bv-notempty="true"
                               data-bv-notempty-message="Họ tên không được để trống"

                               data-bv-stringlength="true"
                               data-bv-stringlength-min="3"
                               data-bv-stringlength-max="255"
                               data-bv-stringlength-message="Họ tên chỉ dài 3-255 ký tự">
                    </div>

                    <div class="form-group">
                        <input type="tel" class="form-control" name="customer[phone]" placeholder="<?php echo __('Số điện thoại của bạn',WPCEMS_TEXTDOMAIN);?>" data-bv-notempty="true"
                               data-bv-notempty-message="Không được để trống số điện thoại"

                               data-bv-stringlength="true"
                               data-bv-stringlength-min="6"
                               data-bv-stringlength-max="15"
                               data-bv-stringlength-message="Số điện thoại chỉ nằm trong 6-15 ký số"

                               data-bv-regexp="true"
                               data-bv-regexp-regexp="^[0-9]+$"
                               data-bv-regexp-message="Số điện thoại chỉ gồm một chuỗi các số">
                    </div>
                    <div class="text-center">
                        <button data-loading-text="Đang gửi ..." type="submit" class="btn btn-primary" id="btn-new-mail-subscribe" ><?php echo __('Gửi',WPCEMS_TEXTDOMAIN);?></button>
                    </div>
					<div class="alert alert-danger alert-dismissible cems-alert" role="alert" style="display: none">
						<button type="button" class="close" data-dismiss="alert">
							<span aria-hidden="true">&times;</span>
							<span class="sr-only">Đóng</span>
						</button>
						<div class="error-response"></div>
					</div>
                </form>
            </div>
        </div>
        <?php
        $content = WPDKHTML::endHTMLCompress();
        return $content;
    }
}