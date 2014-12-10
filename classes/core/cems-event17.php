<?php
/**
 * Created by PhpStorm.
 * User: pnghai
 * Date: 7/9/14
 * Time: 1:09 PM
 */
/**
 * Model of a single CEMSEvent17 template
 *
 * @class           CEMSEvent17
 * @author          pnghai <nguyenhai@siliconstraits.vn>
 * @copyright       Copyright (C) 2014-2015 Silicon Straits. All Rights Reserved.
 * @date            2014-10-15
 * @version         1.0.0
 *
 */
class CEMSEvent17 {

    /**
     * Event ID
     *
     * @brief Event ID
     *
     * @var int $event_id
     */
    public $event_id = -1;

    /**
     * Create an instance of CEMSEvent17 class
     *
     * @brief Construct
     *
     * @param array $attributes Required Shortcode Attributes
     *
     * @return CEMSEvent17
     */
    public function __construct( $attributes)
    {
        extract($attributes);
        if ( !empty( $id ) ) {
            $this->event_id = $id;
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
        <div class="panel panel-default cems-event17-panel">
            <div class="panel-body">
                <form role="form" name="event17-form" id='event17-form' method="post" class="form-horizontal" data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
                      data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
                      data-bv-feedbackicons-validating="glyphicon glyphicon-refresh">
                    <input type="hidden" value="<?php echo $this->event_id;?>" name="event_register[event_id]">
                    <input type="hidden" name="event_register[customer_source]">

                    <div class="form-group">
                        <label for="customer-email" class="control-label"><?php echo __('
Địa chỉ email',WPCEMS_TEXTDOMAIN);?> <sup>*</sup> (Bạn nhớ click Kiểm tra trước khi điền Họ tên)</label>
                        <div class="row">
                            <div class="col-xs-10">
                                <input type="email" class="form-control" id="customer-email" name="customer[email]" placeholder="<?php echo __('Nhập địa chỉ email của bạn',WPCEMS_TEXTDOMAIN);?>" data-bv-notempty="true"
                                       data-bv-notempty-message="Bạn cần điền email"

                                       data-bv-emailaddress="true"
                                       data-bv-emailaddress-message="Email không hợp lệ">
                            </div>
                            <div class="col-xs-2">
                                <button type="button" class="btn btn-warning btn-block btn-check-exist" data-loading-text="Xin chờ ..." data-toggle="tooltip" data-placement="bottom" title="Nếu bạn đã từng đăng ký với chúng tôi, bạn chỉ cần điền email, những thông tin khác sẽ được tự động điền giúp bạn.">Kiểm tra</button>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-danger cems-notify-customer" role="alert" id="cems-notify-customer" style="display: none">
                        <div class="error-response"></div>
                    </div>
                    <div class="form-group">

                        <label for="customer-fullname" class="control-label"><?php echo __('
Họ Tên',WPCEMS_TEXTDOMAIN);?><sup>*</sup></label>
                        <input type="text" class="form-control" id="customer-fullname" name="customer[full_name]" placeholder="<?php echo __('Nhập họ tên',WPCEMS_TEXTDOMAIN);?>" data-bv-notempty="true"
                               data-bv-notempty-message="Họ tên không được để trống"

                               data-bv-stringlength="true"
                               data-bv-stringlength-min="3"
                               data-bv-stringlength-max="255"
                               data-bv-stringlength-message="Họ tên chỉ dài 3-255 ký tự">
                    </div>

                    <div class="form-group">
                        <label for="customer-phone" class="control-label"><?php echo __('
Số điện thoại',WPCEMS_TEXTDOMAIN);?> <sup>*</sup></label>
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


                    <div class="form-group">
                        <label for="customer-birthday" class="control-label">Sinh nhật <sup>*</sup> (Sử dụng dấu cách "-": 20-10-1980)</label>
                        <input type="text" class="form-control" id="customer-birthday" name="customer[birthday]" placeholder="DD-MM-YYYY"
                               data-bv-date="true"
                               data-bv-notempty="true"
                               data-bv-notempty-message="Không được để trống ngày sinh"
                               data-bv-date-format="DD-MM-YYYY"
                               data-bv-date-message="Ngày sinh không hợp lệ"
                               data-provide="datepicker"
                               data-date-format="dd-mm-yyyy"
                               data-date-language="vi"/>
                    </div>


                    <div class="form-group">
                        <label class="control-label">Vì sao bạn biết đến buổi chia sẻ này &nbsp;<span><sup>*</sup></span></label>
                        <div class="radio">
                            <label>
                                <input type="radio" name="event_register[why_you_know]" value="Facebook Life Coaching Vietnam"
                                       data-bv-notempty="true"
                                       data-bv-notempty-message="Bạn chưa chọn nguồn thông tin" /> Facebook Life Coaching Vietnam
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="event_register[why_you_know]" value="Facebook bạn bè người thân chia sẻ" /> Facebook bạn bè người thân chia sẻ
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="event_register[why_you_know]" value="Truyền miệng từ bạn bè người thân" /> Truyền miệng từ bạn bè người thân
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="event_register[why_you_know]" value="Trang web lifecoach.com.vn" /> Trang web lifecoach.com.vn
                            </label>
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
					<div class="alert alert-danger alert-dismissible" role="alert" id="cems-alert" style="display: none">
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