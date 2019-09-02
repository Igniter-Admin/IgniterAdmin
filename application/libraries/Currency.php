<?php  if ( ! defined('BASEPATH')) {exit('No direct script access allowed'); }

	class Currency {


		public function get_currencies_arr() {

			$cur = '{"INR":"India Rupees","USD":"United States Dollars","EUR":"Euro","CAD":"Canada Dollars","GBP":"United Kingdom Pounds","DEM":"Germany Deutsche Marks","FRF":"France Francs","JPY":"Japan Yen","NLG":"Netherlands Guilders","ITL":"Italy Lira","CHF":"Switzerland Francs","DZD":"Algeria Dinars","ARP":"Argentina Pesos","AUD":"Australia Dollars","ATS":"Austria Schillings","BSD":"Bahamas Dollars","BBD":"Barbados Dollars","BEF":"Belgium Francs","BMD":"Bermuda Dollars","BRR":"Brazil Real","BGL":"Bulgaria Lev","CLP":"Chile Pesos","CNY":"China Yuan Renmimbi","CYP":"Cyprus Pounds","CSK":"Czech Republic Koruna","DKK":"Denmark Kroner","XCD":"Eastern Caribbean Dollars","EGP":"Egypt Pounds","FJD":"Fiji Dollars","FIM":"Finland Markka","XAU":"Gold Ounces","GRD":"Greece Drachmas","HKD":"Hong Kong Dollars","HUF":"Hungary Forint","ISK":"Iceland Krona","IDR":"Indonesia Rupiah","IEP":"Ireland Punt","ILS":"Israel New Shekels","JMD":"Jamaica Dollars","JOD":"Jordan Dinar","KRW":"South Korea Won","LBP":"Lebanon Pounds","LUF":"Luxembourg Francs","MYR":"Malaysia Ringgit","MXP":"Mexico Pesos","NZD":"New Zealand Dollars","NOK":"Norway Kroner","PKR":"Pakistan Rupees","XPD":"Palladium Ounces","PHP":"Philippines Pesos","XPT":"Platinum Ounces","PLZ":"Poland Zloty","PTE":"Portugal Escudo","ROL":"Romania Leu","RUR":"Russia Rubles","SAR":"Saudi Arabia Riyal","XAG":"Silver Ounces","SGD":"Singapore Dollars","SKK":"Slovakia Koruna","ZAR":"South Africa Rand","ESP":"Spain Pesetas","XDR":"Special Drawing Right (IMF)","SDD":"Sudan Dinar","SEK":"Sweden Krona","TWD":"Taiwan Dollars","THB":"Thailand Baht","TTD":"Trinidad and Tobago Dollars","TRL":"Turkey Lira","VEB":"Venezuela Bolivar","ZMK":"Zambia Kwacha"}';
			
			return json_decode($cur);
		}


		public function get_currency_dropdown_options($selected = NULL) {
			$currency = $this->get_currencies_arr();
			$options = '';
			foreach ($currency as $cur_key => $cur_value) {
				$sel = '';
				if($selected != '' && $selected == $cur_key) {
					$sel = 'selected';	
				}
				$options .= ' <option value="'.$cur_key.'" '.$sel.' > '.$cur_value.' - ' .$cur_key. ' </option> ';	
			}
			return $options;
		}
	}


?>