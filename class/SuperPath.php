<?php

/**
 * Класс для распределения большого кол-ва файлов по папкам,
 * в зависимости от ID
 */
class SuperPath{
	
	const top_level = 9;

        /**
         *
         * @param string $file_id ID файла
         * @param string $addon_path Подпапка (src/src_eps/0-6)
         * @param bool $relative Если необходимо получить относительный путь от корня сайта
         * @return string
         */
	static public function get($file_id, $addon_path, $relative = false){

		$id = (int)$file_id;
		
		if(strlen($id) > self::top_level || $id == 0){
			return null;
		}
		
		$server_img_path = ($relative)
                        ? '/images/photo/'.$addon_path
                        : APP_FILE_STORE . '/' . $addon_path;

		$img_path = self::leading_zero($id, self::top_level);	
		 
		do {
			$sub_path = substr($img_path,0,2);
			$img_path = substr($img_path,2);
			
			$server_img_path .= '/'.$sub_path;

                        // Если каталога нет, создаём его
			if(!is_dir($server_img_path) && !$relative){
				@mkdir($server_img_path);
			}
			
		} while (strlen($img_path) > 3);
		
		return $server_img_path.'/'.$file_id;
	}

        /**
         * Вспомогательныя функция, дополняет ID до нулями с переди
         */
	protected function leading_zero( $aNumber, $intPart, $floatPart=NULL, $dec_point=NULL, $thousands_sep=NULL) {      
 
		//Note: The $thousands_sep has no real function 
		// because it will be "disturbed" by plain 
		// leading zeros -> the main goal of the function
		$formattedNumber = $aNumber;
		
		if (!is_null($floatPart)) {    
			// without 3rd parameters the "float part" 
			// of the float shouldn't be touched
			$formattedNumber = number_format($formattedNumber, $floatPart, $dec_point, $thousands_sep);
		}
		
		$formattedNumber = str_repeat("0",($intPart + -1 - floor(log10($formattedNumber)))).$formattedNumber;
		
		return $formattedNumber;
	}


}
 
?>