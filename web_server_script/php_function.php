<?php

function _upload_Image($directory, $input_name, $max_size, $setW_H, $setThumbnail) {
    $array = array();
    $index = 0;
    if ($_FILES) {
        $img_name = $_FILES[$input_name]['name'];
        $img_type = $_FILES[$input_name]['type'];
        $img_size = $_FILES[$input_name]['size'];
        $img_tmp = $_FILES[$input_name]['tmp_name'];
        if (is_array($img_tmp)) {
            if (file_exists($directory)) {
                for ($i = 0; $i < count($img_name); $i++) {
                    if ($img_type[$i] == "image/jpeg" || $img_type[$i] == "image/png" || $img_type[$i] == "image/gif") {
                        if ($max_size > ($img_size[$i] / 1024)) {
                            $img_W = getimagesize($img_tmp[$i]);
                            if ($setW_H < $img_W[0] && $setW_H < $img_W[0]) {
                                if (!file_exists($directory . $img_name[$i])) {
                                    $nameRandom = set_namefileUpload($img_name[$i], "Img-");
                                    $content = $directory . $nameRandom;
                                    if (copy($img_tmp[$i], $content)) {
                                        $images = $img_tmp[$i];
                                        if (!file_exists($directory . "thumbnail/")) {
                                            mkdir($directory . "thumbnail");
                                        }
                                        $new_images = $directory . "thumbnail/" . "thumbnails_" . $nameRandom;
                                        $width = $setThumbnail; //*** Fix Width & Heigh (Autu caculate) ** */
                                        $size = GetimageSize($images);
                                        $height = round($width * $size[1] / $size[0]);
                                        if (ereg("(gif)$", $img_name[$i])) {
                                            $images_orig = imagecreatefromgif($images);
                                        } elseif (ereg("(png)$", $img_name[$i])) {
                                            $images_orig = imagecreatefrompng($images);
                                        } else {
                                            $images_orig = imagecreatefromjpeg($images);
                                        }
                                        $photoX = ImagesX($images_orig);
                                        $photoY = ImagesY($images_orig);
                                        $images_fin = ImageCreateTrueColor($width, $height);
                                        ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width + 1, $height + 1, $photoX, $photoY);
                                        if (ereg("(gif)$", $img_name[$i])) {
                                            imageGIF($images_fin, $new_images);
                                        } elseif (ereg("(png)$", $img_name[$i])) {
                                            imagePNG($images_fin, $new_images);
                                        } else {
                                            ImageJPEG($images_fin, $new_images);
                                        }
                                        ImageDestroy($images_orig);
                                        ImageDestroy($images_fin);
                                        $array['data'][$index] = $nameRandom;
                                        $array['sucess'] .= "คัดลอกไฟล์ $img_name[$i] สำเร็จ !<br />";
                                        $index++;
                                    } else {
                                        $array['error'] .= "คัดลอกไฟล์ $img_name[$i] ไม่สำเร็จ !<br />";
                                    }
                                } else {
                                    $array['error'] .= "มีชื่อไฟล์ $img_name[$i] แล้ว กรุณาเปลี่ยนชื่อ !<br />";
                                }
                            } else {
                                $array['error'] .= "ไฟล์ $img_name[$i] มีขนาดความกว้างความสูงน้อยเกินไป !<br />";
                            }
                        } else {
                            $array['error'] .= "ไฟล์ $img_name[$i] มีขนาดมากกว่า $max_size KB !<br />";
                        }
                    } else {
                        $array['error'] .= "ระบบไม่รองรับกับไฟล์ $img_name[$i] นี้ !<br />";
                    }
                }
            } else {
                if (mkdir($directory)) {
                    for ($i = 0; $i < count($img_name); $i++) {
                        if ($img_type[$i] == "image/jpeg" || $img_type[$i] == "image/png" || $img_type[$i] == "image/gif") {
                            if ($max_size > ($img_size[$i] / 1024)) {
                                $img_W = getimagesize($img_tmp[$i]);
                                if ($setW_H < $img_W[0] && $setW_H < $img_W[0]) {
                                    if (!file_exists($directory . $img_name [$i])) {
                                        $nameRandom = set_namefileUpload($img_name[$i], "Img-");
                                        $content = $directory . $nameRandom;
                                        if (copy($img_tmp [$i], $content)) {
                                            $images = $img_tmp[$i];
                                            if (!file_exists($directory . "thumbnail/")) {
                                                mkdir($directory . "thumbnail");
                                            }
                                            $new_images = $directory . "thumbnail/" . "thumbnails_" . $nameRandom;
                                            $width = $setThumbnail; //*** Fix Width & Heigh (Autu caculate) ** */
                                            $size = GetimageSize($images);
                                            $height = round($width * $size[1] / $size[0]);
                                            if (ereg("(gif)$", $img_name[$i])) {
                                                $images_orig = imagecreatefromgif($images);
                                            } elseif (ereg("(png)$", $img_name[$i])) {
                                                $images_orig = imagecreatefrompng($images);
                                            } else {
                                                $images_orig = imagecreatefromjpeg($images);
                                            }
                                            $photoX = ImagesX($images_orig);
                                            $photoY = ImagesY($images_orig);
                                            $images_fin = ImageCreateTrueColor($width, $height);
                                            ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width + 1, $height + 1, $photoX, $photoY);
                                            if (ereg("(gif)$", $img_name [$i])) {
                                                imageGIF($images_fin, $new_images);
                                            } elseif (ereg("(png)$", $img_name[$i])) {
                                                imagePNG($images_fin, $new_images);
                                            } else {
                                                ImageJPEG($images_fin, $new_images);
                                            }
                                            ImageDestroy($images_orig);
                                            ImageDestroy($images_fin);
                                            $array['data'][$index] = $nameRandom;
                                            $array['sucess'] .= "คัดลอกไฟล์ $img_name[$i] สำเร็จ !<br />";
                                            $index++;
                                        } else {
                                            $array['error'] .= "คัดลอกไฟล์ $img_name[$i] ไม่สำเร็จ !<br />";
                                        }
                                    } else {
                                        $array['error'] .= "มีชื่อไฟล์ $img_name[$i] แล้ว กรุณาเปลี่ยนชื่อ !<br />";
                                    }
                                } else {
                                    $array['error'] .= "ไฟล์ $img_name[$i] มีขนาดความกว้างความสูงน้อยเกินไป !<br />";
                                }
                            } else {
                                $array['error'] .= "ไฟล์ $img_name[$i] มีขนาดมากกว่า $max_size KB !<br />";
                            }
                        } else {
                            $array['error'] .= "ระบบไม่รองรับกับไฟล์ $img_name[$i] นี้ !<br />";
                        }
                    }
                } else {
                    $array ['error'] .= "โฟล์เดอร์ $directory ไม่มีกรุณาสร้าง โฟล์เดอร์ดังกล่าว !<br />";
                }
            }
        }/* ----------------------- No Array---------------------------------------- */ else {
            if (file_exists($directory)) {
                if ($img_type == "image/jpeg" || $img_type == "image/png" || $img_type == "image/gif") {
                    if ($max_size > ($img_size / 1024 )) {
                        $img_W = getimagesize($img_tmp);
                        if ($setW_H < $img_W[0] && $setW_H < $img_W[0]) {
                            if (!file_exists($directory . $img_name)) {
                                $nameRandom = set_namefileUpload($img_name, "Img-");
                                $content = $directory . $nameRandom;
                                if (copy($img_tmp, $content)) {
                                    $images = $img_tmp;
                                    if (!file_exists($directory . "thumbnail/")) {
                                        mkdir($directory . "thumbnail");
                                    }
                                    $new_images = $directory . "thumbnail/" . "thumbnails_" . $nameRandom;
                                    $width = $setThumbnail; //*** Fix Width & Heigh (Autu caculate) ** */
                                    $size = GetimageSize($images);
                                    $height = round($width * $size[1] / $size[0]);
                                    if (ereg("(gif)$", $img_name)) {
                                        $images_orig = imagecreatefromgif($images);
                                    } elseif (ereg("(png)$", $img_name)) {
                                        $images_orig = imagecreatefrompng($images);
                                    } else {
                                        $images_orig = imagecreatefromjpeg($images);
                                    }
                                    $photoX = ImagesX($images_orig);
                                    $photoY = ImagesY($images_orig);
                                    $images_fin = ImageCreateTrueColor($width, $height);
                                    ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width + 1, $height + 1, $photoX, $photoY);
                                    if (ereg("(gif)$", $img_name)) {
                                        imageGIF($images_fin, $new_images);
                                    } elseif (ereg("(png)$", $img_name)) {
                                        imagePNG($images_fin, $new_images);
                                    } else {
                                        ImageJPEG($images_fin, $new_images);
                                    }
                                    ImageDestroy($images_orig);
                                    ImageDestroy($images_fin);
                                    $array['data'][$index] = $nameRandom;
                                    $array['sucess'] .= "คัดลอกไฟล์ $img_name สำเร็จ !<br />";
                                    $index++;
                                } else {
                                    $array['error'] .= "คัดลอกไฟล์ $img_name ไม่สำเร็จ !<br />";
                                }
                            } else {
                                $array['error'] .= "มีชื่อไฟล์ $img_name แล้ว กรุณาเปลี่ยนชื่อ !<br />";
                            }
                        } else {
                            $array['error'] .= "ไฟล์ $img_name มีขนาดความกว้างความสูงน้อยเกินไป !<br />";
                        }
                    } else {
                        $array['error'] .= "ไฟล์ $img_name[$i] มีขนาดมากกว่า $max_size KB !<br />";
                    }
                } else {
                    $array['error'] .= "ระบบไม่รองรับกับไฟล์ $img_name นี้ !<br />";
                }
            } else {
                if (mkdir($directory)) {
                    if ($img_type == "image/jpeg" || $img_type == "image/png" || $img_type == "image/gif") {
                        if ($max_size > ($img_size / 1024)) {
                            $img_W = getimagesize($img_tmp);
                            if ($setW_H < $img_W[0] && $setW_H < $img_W[0]) {
                                if (!file_exists($directory . $img_name)) {
                                    $nameRandom = set_namefileUpload($img_name, "Img-");
                                    $content = $directory . $nameRandom;
                                    if (copy($img_tmp, $content)) {
                                        $images = $img_tmp;
                                        if (!file_exists($directory . "thumbnail/")) {
                                            mkdir($directory . "thumbnail");
                                        }
                                        $new_images = $directory . "thumbnail/" . "thumbnails_" . $nameRandom;
                                        $width = $setThumbnail; //*** Fix Width & Heigh (Autu caculate) ** */
                                        $size = GetimageSize($images);
                                        $height = round($width * $size[1] / $size[0]);
                                        if (ereg("(gif)$", $img_name)) {
                                            $images_orig = imagecreatefromgif($images);
                                        } elseif (ereg("(png)$", $img_name)) {
                                            $images_orig = imagecreatefrompng($images);
                                        } else {
                                            $images_orig = imagecreatefromjpeg($images);
                                        }
                                        $photoX = ImagesX($images_orig);
                                        $photoY = ImagesY($images_orig);
                                        $images_fin = ImageCreateTrueColor($width, $height);
                                        ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width + 1, $height + 1, $photoX, $photoY);
                                        if (ereg("(gif)$", $img_name)) {
                                            imageGIF($images_fin, $new_images);
                                        } elseif (ereg("(png)$", $img_name)) {
                                            imagePNG($images_fin, $new_images);
                                        } else {
                                            ImageJPEG($images_fin, $new_images);
                                        }
                                        ImageDestroy($images_orig);
                                        ImageDestroy($images_fin);
                                        $array['data'][$index] = $nameRandom;
                                        $array['sucess'] .= "คัดลอกไฟล์ $img_name สำเร็จ !<br />";
                                        $index++;
                                    } else {
                                        $array['error'] .= "คัดลอกไฟล์ $img_name ไม่สำเร็จ !<br />";
                                    }
                                } else {
                                    $array['error'] .= "มีชื่อไฟล์ $img_name แล้ว กรุณาเปลี่ยนชื่อ !<br />";
                                }
                            } else {
                                $array['error'] .= "ไฟล์ $img_name มีขนาดความกว้างความสูงน้อยเกินไป !<br />";
                            }
                        } else {
                            $array['error'] .= "ไฟล์ $img_name[$i] มีขนาดมากกว่า $max_size KB !<br />";
                        }
                    } else {
                        $array['error'] .= "ระบบไม่รองรับกับไฟล์ $img_name นี้ !<br />";
                    }
                } else {
                    $array['error'] .= "โฟล์เดอร์ $directory ไม่มีกรุณาสร้าง โฟล์เดอร์ดังกล่าว !<br />";
                }
            }
        }
    }
    return $array;
}

function _upload_sound($directory, $input_name, $max_size) {
    $array = array();
    $index = 0;
    if ($_FILES) {
        $sound_name = $_FILES[$input_name]['name'];
        $sound_type = $_FILES[$input_name]['type'];
        $sound_size = $_FILES[$input_name]['size'];
        $sound_tmp = $_FILES[$input_name]['tmp_name'];
        if (is_array($sound_name)) {
            if (file_exists($directory)) {
                for ($index1 = 0; $index1 < count($sound_name); $index1++) {
                    if ($max_size >= ($sound_size[$index1] / 1024)) {
                        $nameRandom = set_namefileUpload($sound_name[$index1], "Sound-");
                        $content = $directory . $nameRandom;
                        if (!file_exists($content)) {
                            if (copy($sound_tmp[$index1], $content)) {
                                $array['data'][$index] = $nameRandom;
                                $array['sucess'] .= "อัพโหลดไฟล์ " . $sound_name[$index1] . " สำเร็จ !<br />";
                                $index++;
                            } else {
                                $array['sucess'] .= "คัดลอกไฟล์ $sound_name[$index1] ไม่สำเร็จ !<br />";
                            }
                        } else {
                            $array['error'] .= "ไฟล์ชื่อ $sound_name[$index1] มีในระบบแล้ว !<br />";
                        }
                    } else {
                        $array['error'] .= "ไฟล์ $sound_name[$index1] มีขนาดมากกว่า $max_size KB !<br />";
                    }
                }
            } else {
                if (mkdir($directory)) {
                    for ($index1 = 0; $index1 < count($sound_name); $index1++) {
                        if ($max_size >= ($sound_size[$index1] / 1024)) {
                            $nameRandom = set_namefileUpload($sound_name[$index1], "Sound-");
                            $content = $directory . $nameRandom;
                            if (!file_exists($content)) {
                                if (copy($sound_tmp[$index1], $content)) {
                                    $array['data'][$index] = $nameRandom;
                                    $array['sucess'] .= "อัพโหลดไฟล์ " . $sound_name[$index1] . " สำเร็จ !<br />";
                                    $index++;
                                } else {
                                    $array['sucess'] .= "คัดลอกไฟล์ $sound_name[$index1] ไม่สำเร็จ !<br />";
                                }
                            } else {
                                $array['error'] .= "ไฟล์ชื่อ $sound_name[$index1] มีในระบบแล้ว !<br />";
                            }
                        } else {
                            $array['error'] .= "ไฟล์ $sound_name[$index1] มีขนาดมากกว่าที่ระบบกำหนดไว้ !<br />";
                        }
                    }
                } else {
                    $array['error'] .= "โฟล์เดอร์ $directory ไม่มีกรุณาสร้าง โฟล์เดอร์ดังกล่าว !<br />";
                }
            }
        }/* ---------------------------- No Array ------------------------ */ else {
            if (file_exists($directory)) {
                if ($max_size >= ($sound_size / 1024)) {
                    $nameRandom = set_namefileUpload($sound_name, "Sound-");
                    $content = $directory . $nameRandom;
                    if (!file_exists($content)) {
                        if (copy($sound_tmp, $content)) {
                            $array['data'][$index] = $nameRandom;
                            $array['sucess'] .= "อัพโหลดไฟล์ " . $sound_name . " สำเร็จ !<br />";
                            $index++;
                        } else {
                            $array['sucess'] .= "คัดลอกไฟล์ $sound_name ไม่สำเร็จ !<br />";
                        }
                    } else {
                        $array['error'] .= "ไฟล์ชื่อ $sound_name มีในระบบแล้ว !<br />";
                    }
                } else {
                    $array['error'] .= "ไฟล์ $sound_name มีขนาดมากกว่าที่ระบบกำหนดไว้ !<br />";
                }
            } else {
                if (mkdir($directory)) {
                    if ($max_size >= ($sound_size / 1024)) {
                        $nameRandom = set_namefileUpload($sound_name, "Sound-");
                        $content = $directory . $nameRandom;
                        if (!file_exists($content)) {
                            if (copy($sound_tmp, $content)) {
                                $array['data'][$index] = $nameRandom;
                                $array['sucess'] .= "อัพโหลดไฟล์ " . $sound_name . " สำเร็จ !<br />";
                                $index++;
                            } else {
                                $array['sucess'] .= "คัดลอกไฟล์ $sound_name ไม่สำเร็จ !<br />";
                            }
                        } else {
                            $array['error'] .= "ไฟล์ชื่อ $sound_name มีในระบบแล้ว !<br />";
                        }
                    } else {
                        $array['error'] .= "ไฟล์ $sound_name มีขนาดมากกว่าที่ระบบกำหนดไว้ !<br />";
                    }
                } else {
                    $array['error'] .= "โฟล์เดอร์ $directory ไม่มีกรุณาสร้าง โฟล์เดอร์ดังกล่าว !<br />";
                }
            }
        }
    }
    return $array;
}

function set_namefileUpload($file_name, $index_name) {
    $str = md5(rand(0, 10000));
    $newFilename = "$index_name" . (substr($str, 0, 7));
    if ($_FILES) {
        if (eregi("(jpg|jpeg)$", $file_name)) {
            $newFilename.=".jpg";
        } elseif (eregi("(gif)$", $file_name)) {
            $newFilename.=".gif";
        } elseif (eregi("(png)$", $file_name)) {
            $newFilename.=".png";
        } elseif (eregi("(mp3)$", $file_name)) {
            $newFilename.=".mp3";
        } elseif (eregi("(ogg)$", $file_name)) {
            $newFilename.=".ogg";
        } elseif (eregi("(txt)$", $file_name)) {
            $newFilename.=".txt";
        } elseif (eregi("(pdf)$", $file_name)) {
            $newFilename.=".pdf";
        } elseif (eregi("(docx?)$", $file_name)) {
            $newFilename.=".doc";
        } else {
            $newFilename = "$index_name" . (substr($str, 0, 3));
            $newFilename .= "_NameError";
        }
    } else {
        $newFilename = "NoUploadFile.dll";
    }
    return $newFilename;
}

function checkPayment($check) {
    switch ($check) {
        case 1:
            $Payment = "ชำระผ่าน PAYSBUY";
            break;
        case 2:
            $Payment = "โอนเงินเข้าบัญชีธนาคาร";
            break;
        case 3:
            $Payment = "ส่งพัสดุเก็บเงินปลายทาง";
            break;
        case 4:
            $Payment = "ชำระผ่าน PAYPAL";
            break;
        case 5:
            $Payment = "ชำระเงินและรับสินค้าที่ร้าน";
            break;
    }
    return $Payment;
}

$ORDER_status = array(
    "รายการสั่งซื้อใหม่",
    "กำลังตรวจสอบรายการสั่งซื้อ",
    "จัดส่งสินค้าไปแล้ว",
    "รายการสั่งซื้อใหม่ ชำระเงินแล้ว",
    "เกิดข้อขัดข้อง ลูกค้ายกเลิกการจ่ายเงิน",
    "รายการเสร็จสิ้น",
    "เกิดข้อขัดข้องอื่นๆ"
);

function order_status($check) {
    global $ORDER_status;
    switch ($check) {
        case 0:
            $Payment = $ORDER_status[0];
            break;
        case 1:
            $Payment = $ORDER_status[1];
            break;
        case 2:
            $Payment = $ORDER_status[2];
            break;
        case 3:
            $Payment = $ORDER_status[3];
            break;
        case 4:
            $Payment = $ORDER_status[4];
            break;
        case 5:
            $Payment = $ORDER_status[5];
            break;
        case 6:
            $Payment = $ORDER_status[6];
            break;
    }
    return $Payment;
}

function search_price_product($variable) {
    switch ($variable) {
        case 1:
            $sql_search = "select * from product where product_price < 500";
            break;
        case 2:
            $sql_search = "select * from product where product_price between 500 and 5000";
            break;
        case 3:
            $sql_search = "select * from product where product_price between 5000 and 10000";
            break;
        case 4:
            $sql_search = "select * from product where product_price between 10000 and 25000";
            break;
        case 5:
            $sql_search = "select * from product where product_price > 25000";
            break;
    }
    return $sql_search;
}
