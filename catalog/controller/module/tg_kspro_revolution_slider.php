<?php
class ControllerModuleTGKSproRevolutionSlider extends Controller {
	public function index($setting) {
		
		$this->load->model('slider/tg_kspro_revolution_slider');

		$data['slider'] = $this->model_slider_tg_kspro_revolution_slider->getSlider($setting['slider_id']);
		
		$data['language_id'] = $this->config->get('config_language_id');
		
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/tg_kspro_revolution_slider.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/module/tg_kspro_revolution_slider.tpl', $data);
		} else {
			return $this->load->view('default/template/module/tg_kspro_revolution_slider.tpl', $data);
		}
	}
}
?>