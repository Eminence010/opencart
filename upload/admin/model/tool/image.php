<?php
class ModelToolImage extends Model {
	public function resize($filename, $width, $height) {
		if (!is_file(DIR_IMAGE . $filename) || substr(str_replace('\\', '/', realpath(DIR_IMAGE . $filename)), 0, strlen(DIR_IMAGE)) != str_replace('\\', '/', DIR_IMAGE)) {
			return;
		}

		// 返回文件路径的信息
		$extension = pathinfo($filename, PATHINFO_EXTENSION);

		$image_old = $filename;
		$image_new = 'cache/' . utf8_substr($filename, 0, utf8_strrpos($filename, '.')) . '-' . $width . 'x' . $height . '.' . $extension;

		// 新图片文件不存在，或者 修改时间<原图片文件修改时间
		// filemtime — 取得文件修改时间
		if (!is_file(DIR_IMAGE . $image_new) || (filemtime(DIR_IMAGE . $image_old) > filemtime(DIR_IMAGE . $image_new))) {
			list($width_orig, $height_orig, $image_type) = getimagesize(DIR_IMAGE . $image_old);
				 
			if (!in_array($image_type, array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF))) { 
				return DIR_IMAGE . $image_old;
			}
 
			$path = '';

            // explode — 使用一个字符串分割另一个字符串
			$directories = explode('/', dirname($image_new));

			foreach ($directories as $directory) {
				$path = $path . '/' . $directory;

				if (!is_dir(DIR_IMAGE . $path)) {
				    // 默认的 mode 是 0777，意味着最大可能的访问权。
					@mkdir(DIR_IMAGE . $path, 0777);
				}
			}

			// 宽或高不一致，新建文件
			if ($width_orig != $width || $height_orig != $height) {
				$image = new Image(DIR_IMAGE . $image_old);
				$image->resize($width, $height);
				$image->save(DIR_IMAGE . $image_new);
			} else {    // 否则拷贝
				copy(DIR_IMAGE . $image_old, DIR_IMAGE . $image_new);
			}
		}

		return HTTP_CATALOG . 'image/' . $image_new;
	}
}
