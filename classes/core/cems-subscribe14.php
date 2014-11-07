<?php
/**
 * Created by PhpStorm.
 * User: pnghai
 * Date: 7/9/14
 * Time: 1:09 PM
 */
/**
 * Model of a single CEMSSubscribeForm14 template
 *
 * @class           CEMSSubscribeForm14
 * @author          pnghai <nguyenhai@siliconstraits.vn>
 * @copyright       Copyright (C) 2014-2015 Silicon Straits. All Rights Reserved.
 * @date            2014-10-15
 * @version         1.0.0
 *
 */
class CEMSSubscribeForm14 {

    /**
     * Event ID
     *
     * @brief Event ID
     *
     * @var int $list_id
     */
    public $list_id = -1;

    /**
     * Create an instance of CEMSSubscribeForm14 class
     *
     * @brief Construct
     *
     * @param array $attributes Required Shortcode Attributes
     *
     * @return CEMSSubscribeForm14
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
        <div class="panel panel-default cems-subscription14-panel">
            <div class="panel-body">
                <form role="form" name="subscription14-form" id='subscription14-form' method="post" class="form-horizontal subscriptionForm" data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
                      data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
                      data-bv-feedbackicons-validating="glyphicon glyphicon-refresh">
                    <input type="hidden" value="<?php echo $this->list_id;?>" name="subscription[subscriber_list_id]">
                    <input type="hidden" name="subscription[customer_source]">

                    <div class="form-group">
                        <label for="customer-email" class="col-sm-3 control-label"><?php echo __('
Địa chỉ email',WPCEMS_TEXTDOMAIN);?><sup>*</sup></label>
                        <div class="col-sm-6">
                            <input type="email" class="form-control" id="customer-email" name="customer[email]" placeholder="<?php echo __('Nhập địa chỉ email của bạn',WPCEMS_TEXTDOMAIN);?>" data-bv-notempty="true"
                                   data-bv-notempty-message="Bạn cần điền email"

                                   data-bv-emailaddress="true"
                                   data-bv-emailaddress-message="Email không hợp lệ">
                        </div>
                        <div class="col-sm-3">
                            <button type="button" class="btn btn-default btn-check-exist" data-loading-text="Xin chờ ..." >Kiểm tra</button>
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
                        <label class="col-sm-3 control-label">Bạn muốn thực hiện Career Coaching hay Life Coaching?<sup>*</sup></label>
                        <div class="col-sm-8">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="subscription[what_you_want][]" value="Career coaching"
                                           data-bv-notempty="true"
                                           data-bv-notempty-message="Bạn chưa chọn nguồn thông tin" />Career coaching
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="subscription[what_you_want][]" value="Life coaching" />Life coaching
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="subscription-why_register">Vì sao bạn đăng ký? Bạn muốn đạt được điều gì sau các buổi coaching?</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" rows="3" id="subscription-why_register" name="subscription[why_register]"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="subscription-booking_date" class="col-sm-3 control-label">Chọn ngày bạn muốn gặp. Life Coaching Vietnam sẽ gọi điện xác nhận trong vòng 24 tiếng.<sup>*</sup></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="subscription-booking_date" name="subscription[booking_date]" placeholder="DD-MM-YYYY"
                                   data-bv-date="true"
                                   data-bv-date-format="DD-MM-YYYY"
                                   data-bv-date-message="Ngày không hợp lệ"
                                   data-provide="datepicker"
                                   data-date-format="dd-mm-yyyy"
                                   data-date-language="vi"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Chọn hình thức coaching:</label>
                        <div class="col-sm-8">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="subscription[coaching_type][]" value="Email" />Email
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="subscription[coaching_type][]" value="Skype" />Skype
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="subscription[coaching_type][]" value="Gặp mặt trực tiếp" />Gặp mặt trực tiếp
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Chọn số người sẽ gặp coach</label>
                        <div class="col-sm-8">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="subscription[coaching_type]" value="1 mình bạn" />1 mình bạn
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="subscription[number_clients]" value="Bạn và 1 người nữa" />Bạn và 1 người nữa
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="subscription[number_clients]" value="Bạn và 2 người trở lên" />Bạn và 2 người trở lên
                                </label>
                            </div>
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