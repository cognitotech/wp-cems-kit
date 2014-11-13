<?php
/**
 * Created by PhpStorm.
 * User: pnghai
 * Date: 7/9/14
 * Time: 1:09 PM
 */
/**
 * Model of a single CEMSSubscribeForm15 template
 *
 * @class           CEMSSubscribeForm15
 * @author          pnghai <nguyenhai@siliconstraits.vn>
 * @copyright       Copyright (C) 2014-2015 Silicon Straits. All Rights Reserved.
 * @date            2014-10-15
 * @version         1.0.0
 *
 */
class CEMSSubscribeForm15 {

    /**
     * Event ID
     *
     * @brief Event ID
     *
     * @var int $list_id
     */
    public $list_id = -1;

    /**
     * Create an instance of CEMSSubscribeForm15 class
     *
     * @brief Construct
     *
     * @param array $attributes Required Shortcode Attributes
     *
     * @return CEMSSubscribeForm15
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
        <div class="panel panel-default cems-subscription15-panel">
            <div class="panel-body">
                <form role="form" name="subscription15-form" id='subscription15-form' method="post" class="form-horizontal subscriptionForm" data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
                      data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
                      data-bv-feedbackicons-validating="glyphicon glyphicon-refresh">
                    <input type="hidden" value="<?php echo $this->list_id;?>" name="subscription[subscriber_list_id]">
                    <input type="hidden" name="subscription[customer_source]">

                    <div class="form-group">
                        <label for="customer-email" class="col-sm-3 control-label"><?php echo __('
Địa chỉ email',WPCEMS_TEXTDOMAIN);?><sup>*</sup></label>
                        <div class="col-sm-7">
                            <input type="email" class="form-control" id="customer-email" name="customer[email]" placeholder="<?php echo __('Nhập địa chỉ email của bạn',WPCEMS_TEXTDOMAIN);?>" data-bv-notempty="true"
                                   data-bv-notempty-message="Bạn cần điền email"

                                   data-bv-emailaddress="true"
                                   data-bv-emailaddress-message="Email không hợp lệ">
                        </div>
                        <div class="col-sm-2">
                            <button type="button" class="btn btn-default btn-block btn-check-exist" data-loading-text="Xin chờ ..." >Kiểm tra</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12 text-center">
                            Nếu bạn đã từng đăng ký với chúng tôi, bạn chỉ cần điền email, những thông tin khác sẽ được tự động điền giúp bạn.
                        </div>
                    </div>
                    <div class="alert alert-danger" role="alert" id="cems-notify-customer" style="display: none">
                        <div class="error-response"></div>
                    </div>
                    <div class="form-group">
                        <label for="customer-fullname" class="col-sm-3 control-label"><?php echo __('
Họ Tên',WPCEMS_TEXTDOMAIN);?><sup>*</sup></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="customer-fullname" name="customer[full_name]" placeholder="<?php echo __('Nhập họ tên',WPCEMS_TEXTDOMAIN);?>" data-bv-notempty="true"
                                   data-bv-notempty-message="Họ tên không được để trống"

                                   data-bv-stringlength="true"
                                   data-bv-stringlength-min="3"
                                   data-bv-stringlength-max="255"
                                   data-bv-stringlength-message="Họ tên chỉ dài 3-255 ký tự">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="customer-phone" class="col-sm-3 control-label"><?php echo __('
Số điện thoại',WPCEMS_TEXTDOMAIN);?><sup>*</sup></label>
                        <div class="col-sm-8">
                            <input type="tel" class="form-control" id="customer-phone" name="customer[phone]" placeholder="<?php echo __('Nhập số điện thoại của bạn',WPCEMS_TEXTDOMAIN);?>" data-bv-notempty="true"
                                   data-bv-notempty-message="Không được để trống số điện thoại"

                                   data-bv-stringlength="true"
                                   data-bv-stringlength-min="6"
                                   data-bv-stringlength-max="15"
                                   data-bv-stringlength-message="Số điện thoại chỉ nằm trong 6-15 ký số"

                                   data-bv-regexp="true"
                                   data-bv-regexp-regexp="^[0-9]+$"
                                   data-bv-regexp-message="Số điện thoại chỉ gồm một chuỗi các số">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="customer-birthday" class="col-sm-3 control-label">Sinh nhật</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="customer-birthday" name="customer[birthday]" placeholder="DD-MM-YYYY"
                                   data-bv-date="true"
                                   data-bv-date-format="DD-MM-YYYY"
                                   data-bv-date-message="Ngày sinh không hợp lệ"
                                   data-provide="datepicker"
                                   data-date-format="dd-mm-yyyy"
                                   data-date-language="vi"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="subscription-why_know_htt20">Vì sao bạn biết đến HTT20 (ghi rõ tên người giới thiệu)?</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="subscription-why_know_htt20" name="subscription[why_know_htt20]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="subscription-why_join_htt20">Vì sao bạn muốn tham gia HTT20?</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" rows="3" id="subscription-why_join_htt20" name="subscription[why_join_htt20]"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="subscription-result_detail_htt20">Những kết quả cụ thể mà bạn muốn đạt được sau khi tham gia HTT20?</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" rows="3" id="subscription-result_detail_htt20" name="subscription[result_detail_htt20]"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="subscription-action_plan_htt20">Hãy nêu những hành động cụ thể mà bạn sẵn sàng làm ngay để đạt được những mục tiêu đề ra khi tham gia HTT20?</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" rows="3" id="subscription-action_plan_htt20" name="subscription[action_plan_htt20]"></textarea>
                        </div>
                    </div>

                    <div class="alert alert-warning" role="alert">
                        <strong>Bạn nhớ nha:</strong>  Life Coaching Vietnam sẽ gửi thông tin đến địa chỉ email bạn đăng ký. Vui lòng nhập email chính xác.
                    </div>
                    <div class="form-group">
                        <div class="text-center">
                            <button data-loading-text="Đang gửi ..." type="submit" class="btn btn-primary" id="btn-new-customer" ><?php echo __('Gửi',WPCEMS_TEXTDOMAIN);?></button>
                            <button class="btn btn-default btn-reset"><?php echo __('Điền lại',WPCEMS_TEXTDOMAIN);?></button>
                        </div>
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