<?php
namespace Src\Interfaces;
interface InterfaceView{
    public function setDir($Dir);
    public function setTitle($Title);
    public function setDescription($Description);
    public function setKeywords($Keywords);
    public function renderLayout();
}
?>