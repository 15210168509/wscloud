<?php
namespace Office\Model;

class DeviceModel extends ApiModel
{
    public function getList($para){
        $url = '/Device/deviceLists/';
        foreach($para as $key=>$value){
            $url .= $key.'/'.$value.'/';
        }
        $result = $this->getResult($url.rtrim('/'));
        return $result;
    }

    /**
     * 添加设备
     * @param $data
     * @return string
     */
    public function ajaxAddDevice($data)
    {
        return $this->getResult('/Device/ajaxAddDevice','post',$data);
    }

    /**
     * 激活设备
     * @param $id
     * @return string
     */
    public function activeDevice($id)
    {
        return $this->getResult("/Device/activeDevice/id/$id",'get');
    }

    /**
     * 删除设备
     * @param $id
     * @return string
     */
    public function delDevice($id)
    {
        return $this->getResult("/Device/delDevice/id/$id",'get');
    }

    public function getPackage($companyId)
    {
        return $this->getResult("/Company/getPackageInfo/id/$companyId",'get');
    }

    /**
     * 获取设备配置
     * @param $data
     * @return string
     */
    public function getDeviceSettingInfo($data)
    {
        return $this->getResult("/Device/getDeviceSettingInfo",'post',$data);
    }

    /**
     * 添加公司设备配置
     * @param $data
     * @return string
     */
    public function ajaxAddDeviceSetting($data)
    {
        return $this->getResult("/Device/ajaxAddDeviceSetting",'post',$data);
    }

    /**
     * 获取公司下设备的配置信息
     * @param $companyId
     * @return string
     */
    public function getCompanyDeviceSetting($companyId)
    {
        return $this->getResult("/Device/getCompanyDeviceSetting/company_id/$companyId",'get');
    }

    /**
     * 修改配置
     * @param $data
     * @return string
     */
    public function ajaxSaveDeviceSetting($data)
    {
        return $this->getResult("/Device/ajaxSaveDeviceSetting",'post',$data);
    }

    /**
     * 重启设备
     * @param $serialNo
     * @return string
     */
    public function restartDevice($serialNo)
    {
        return $this->getResult("/Device/restartDevice/serialNo/$serialNo",'get');
    }

    /**
     * 升级设备
     * @param $serialNo
     * @return string
     */
    public function updateDevice($serialNo)
    {
        return $this->getResult("/Device/updateDevice/serialNo/$serialNo",'get');
    }

    /**
     * 推送消息
     * @param $serialNo
     * @param $type
     * @return string
     */
    public function pushMsg($serialNo,$type)
    {
        return $this->getResult("/Device/pushMsg/serialNo/$serialNo/type/$type",'get');
    }

}