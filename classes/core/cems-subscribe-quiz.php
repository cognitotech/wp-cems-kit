<?php
/**
 * Created by PhpStorm.
 * User: pnghai
 * Date: 7/9/14
 * Time: 1:09 PM
 */
/**
 * Model of a single CEMSSubscribeQuiz template
 *
 * @class           CEMSSubscribeQuiz
 * @author          pnghai <nguyenhai@siliconstraits.vn>
 * @copyright       Copyright (C) 2014-2015 Silicon Straits. All Rights Reserved.
 * @date            2014-10-15
 * @version         1.0.0
 *
 */
class CEMSSubscribeQuiz {

    /**
     * SubscribeList ID
     *
     * @brief SubscribeList ID
     *
     * @var int $list_id
     */
    public $list_id = -1;

    /**
     * Quiz Shortcode
     * @var string $quiz
     */
    public $quiz = '';

    /**
     * Create an instance of CEMSSubscribeQuiz class
     *
     * @brief Construct
     *
     * @param array $attributes Required Shortcode Attributes
     *
     * @return CEMSSubscribeQuiz
     */
    public function __construct( $attributes)
    {
        extract($attributes);
        if ( !empty( $id ) ) {
            $this->list_id = $id;
        }
        if (!empty( $quiz ) ) {
            $this->quiz = $quiz;
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
        <div class="panel panel-default cems-subscriptionQuiz-panel">
            <div class="panel-body">
                <form role="form" name="subscriptionQuiz" id='subscriptionQuiz' method="post" class="form-horizontal subscriptionQuiz" data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
                      data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
                      data-bv-feedbackicons-validating="glyphicon glyphicon-refresh">
                    <input type="hidden" value="<?php echo $this->list_id;?>" name="subscription[subscriber_list_id]">
                    <input type="hidden" name="subscription[customer_source]">
                    <input type="hidden" name="quiz[id]" value="<?php echo $this->quiz;?>">

                    <div class="form-group">
                        <label for="customer-email" class="col-sm-3 control-label"><?php echo __('
Địa chỉ email',WPCEMS_TEXTDOMAIN);?><sup>*</sup></label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" id="customer-email" name="customer[email]" placeholder="<?php echo __('Nhập địa chỉ email của bạn',WPCEMS_TEXTDOMAIN);?>" data-bv-notempty="true"
                                   data-bv-notempty-message="Bạn cần điền email"

                                   data-bv-emailaddress="true"
                                   data-bv-emailaddress-message="Email không hợp lệ">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="customer-fullname" class="col-sm-3 control-label"><?php echo __('
Họ Tên',WPCEMS_TEXTDOMAIN);?><sup>*</sup></label>
                        <div class="col-sm-9">
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
                        <div class="col-sm-9">
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
                        <div class="col-sm-9">
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
                        <label class="col-sm-3 control-label" for="subscription-register_source">Bạn biết đến thông tin qua nguồn nào?</label>
                        <div class="col-sm-9">
                            <select class="select optional" id="customer-register_source" name="customer[register_source]">
                                <option value="" selected></option>
                                <option value="Được giới thiệu">Được giới thiệu</option>
                                <option value="Sự kiện của YDC">Sự kiện của YDC</option>
                                <option value="Các tựa sách">Các tựa sách</option>
                                <option value="Báo và tạp chí giấy">Báo và tạp chí giấy</option>
                                <option value="Báo điện tử">Báo điện tử</option>
                                <option value="Tìm kiếm trên google">Tìm kiếm trên google</option>
                                <option value="Youtube">Youtube</option>
                                <option value="Facebook">Facebook</option>
                                <option value="Các diễn đàn">Các diễn đàn</option>
                                <option value="Khác">Khác</option></select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="text-center">
                            <button data-loading-text="Đang gửi ..." type="submit" class="btn btn-primary" id="btn-new-customer" ><?php echo __('Đăng ký',WPCEMS_TEXTDOMAIN);?></button>
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