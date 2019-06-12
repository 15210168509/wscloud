<?php
namespace Office\Controller;
use Lib\Code;
use Lib\CommonConst;
use Lib\ListManagementController;
use Lib\Msg;
use Lib\StatusCode;
use Lib\Ws\WsClient;

/**
 * Created by 李文起
 * User: 01
 * Date: 2018/5/21
 * Time: 10:52
 */
class StatController extends ListManagementController
{
    public function statBehavior($startTime, $endTime)
    {
        if (isset($startTime) && isset($endTime)) {

            $startTime = strtotime($startTime);
            $endTime = strtotime($endTime);

            $model = D('DrivingMonitor');
            $res = $model->statByDayGroup($this->context->loginuser->company_id, $startTime, $endTime);

            $this->ajaxReturn(array('code' => Code::OK, 'msg' => $res['msg'], 'status_code' => $res['status_code'], 'data' => $res['data']));
        } else {
            $this->ajaxReturn(array('code' => Code::ERROR, Msg::PARA_MISSING, StatusCode::PARA_MISSING));
        }
    }

    /**
     *
     * 疲劳次数
     */
    public function showTiredNumber()
    {

        $endTime = time();
        if (I('post.timeType') == 30) {
            $startTime = time() - 3600 * 30 * 24;
        } else if (I('post.timeType') == 7) {
            $startTime = time() - 3600 * 30 * 7;
        } else {
            $startTime = time() - 3600 * 30 * 3;
        }
        $model = D('DrivingMonitor');
        $res = $model->statByDayGroup($this->context->loginuser->company_id, $startTime, $endTime);
        if ($res['code'] == Code::OK) {
            $data = [];
            foreach ($res['data'] as $k => $v) {
                $data['xAxis'][] = $k;
                $data['yAxis'][] = $v;
            }
            $this->ajaxReturn(array('code' => Code::OK, 'msg' => $res['msg'], 'data' => $data));
        } else {
            $this->ajaxReturn(array('code' => Code::ERROR, 'msg' => $res['msg']));
        }

    }

    /**
     * 行为类型统计
     */
    public function showTiredType()
    {
        $model = D('DrivingMonitor');
        if (I('post.timeType') == 30) {
            $startTime = time() - 3600 * 30 * 24;
        } else if (I('post.timeType') == 7) {
            $startTime = time() - 3600 * 30 * 7;
        } else if (I('post.timeType') == 3) {
            $startTime = time() - 3600 * 30 * 3;
        } else {
            $startTime = strtotime(date("Y-m-d", time()));
        }
        $endTime = time();
        $res = $model->showTiredType($startTime, $endTime, $this->context->loginuser->company_id);
        $this->ajaxReturn(array('code' => $res['code'], 'msg' => $res['msg'], 'data' => $res['data']));
    }

    /**
     * 报警集中时间段
     */
    public function statByTimeGroup()
    {

        $endTime = strtotime(date("Y-m-d", time())) + 3600 * 24;
        if (I('post.timeType') == 30) {
            $startTime = strtotime(date("Y-m-d", (time() - 3600 * 24 * 30)));
        } else if (I('post.timeType') == 7) {
            $startTime = strtotime(date("Y-m-d", (time() - 3600 * 24 * 7)));
        } else {
            $startTime = strtotime(date("Y-m-d", (time() - 3600 * 24 * 3)));
        }
        $model = D('DrivingMonitor');
        $res = $model->statByTimeGroup($this->context->loginuser->company_id, $startTime, $endTime);

        if ($res['code'] == Code::OK) {
            $this->ajaxReturn(array('code' => Code::OK, 'msg' => $res['msg'], 'data' => $res['data']));
        } else {
            $this->ajaxReturn(array('code' => Code::ERROR, 'msg' => $res['msg']));
        }
    }

    /**
     * 疲劳值
     */
    public function showTiredValue()
    {
        $arr['device_no'] = array_unique(I('post.device'));
        $model = D('DrivingMonitor');
        $res = $model->showTiredValue($arr);
        $this->ajaxReturn(array('code' => $res['code'], 'msg' => $res['msg'], 'data' => $res['data']));
    }

    /**
     * 车辆列表
     * author 李文起
     * @param string $groupId
     */
    public function getVehicleListByGroups($groupId = 'null')
    {
        $model = D('Vehicle');
        $res = $model->getVehicleListByGroups($this->context->loginuser->company_id, $groupId);
        $this->ajaxReturn(array('code' => $res['code'], 'msg' => $res['msg'], 'status_code' => $res['status_code'], 'data' => $res['data']));
    }

    /**
     * 根据类型获取所有分组
     * author 李文起
     * @param string $type
     */

    /**
     * 实时报警次数（当天零点起）
     */
    public function statTiredNo()
    {
        $model = D('DrivingMonitor');
        $time = strtotime(date('Y-m-d',time()));
        $res = $model->statTiredNo($this->context->loginuser->company_id, $time);
        $this->ajaxReturn(array('code' => $res['code'], 'msg' => $res['msg'], 'data' => $res['data']));
    }

    public function showVehicle()
    {
        $arr = I('post.device');

        $model = D('DrivingMonitor');
        $res = $model->showVehicle($arr);
        $time = time();
        $data = [];
        $data['driving']['north'] = [];
        $data['driving']['south'] = [];
        $data['driving']['west'] = [];
        $data['driving']['east'] = [];

        $data['stop']['north'] = [];
        $data['stop']['west'] = [];
        $data['stop']['south'] = [];
        $data['stop']['east'] = [];

        $data['offLine']['north'] = [];
        $data['offLine']['west'] = [];
        $data['offLine']['south'] = [];
        $data['offLine']['east'] = [];
        if ($res['code'] == Code::OK) {

            foreach ($res['data'] as $val) {

                $vehicle = [];
                if ($val['position_info']) {

                    $vehicleInfo = [];
                    $vehicleInfo['speed'] = $val['position_info']['speed'] ? $val['position_info']['speed'] : 0;
                    $vehicleInfo['gps_time'] = date('Y-m-d H:i:s', $val['position_info']['gps_time']);
                    $vehicleInfo['position'] = !empty($val['position_info']['lng']) && !empty($val['position_info']['lat']) ? $this->getMapLocation($val['position_info']['lng'], $val['position_info']['lat']) : '未知';

                    $vehicle[] = $val['position_info']['lng'];
                    $vehicle[] = $val['position_info']['lat'];
                    $vehicle[] = $val['vehicle_no'];
                    $vehicle[] = $vehicleInfo;

                    if (($time - $val['position_info']['gps_time']) >= 1800) {
                        //离线
                        if ((275<=$val['position_info']['course']) || ($val['position_info']['course'] < 45)) {
                            $data['offLine']['north'][] = $vehicle;
                        }
                        if ((45<=$val['position_info']['course']) && ($val['position_info']['course'] < 135)) {
                            $data['offLine']['east'][] = $vehicle;
                        }
                        if ((135<=$val['position_info']['course']) && ($val['position_info']['course'] < 225)) {
                            $data['offLine']['south'][] = $vehicle;
                        }
                        if ((225<=$val['position_info']['course']) && ($val['position_info']['course'] < 275)) {
                            $data['offLine']['west'][] = $vehicle;
                        }

                    } else {
                        if ($vehicleInfo['speed'] > 0) {
                            //运动
                            if ((275<=$val['position_info']['course']) || ($val['position_info']['course'] < 45)) {
                                $data['driving']['north'][] = $vehicle;
                            }
                            if ((45<=$val['position_info']['course']) && ($val['position_info']['course'] < 135)) {
                                $data['driving']['east'][] = $vehicle;
                            }
                            if ((135<=$val['position_info']['course']) && ($val['position_info']['course'] < 225)) {
                                $data['driving']['south'][] = $vehicle;
                            }
                            if ((225<=$val['position_info']['course']) && ($val['position_info']['course'] < 275)) {
                                $data['driving']['west'][] = $vehicle;
                            }
                        } else {
                            //静止
                            if ((275<=$val['position_info']['course']) || ($val['position_info']['course'] < 45)) {
                                $data['stop']['north'][] = $vehicle;
                            }
                            if ((45<=$val['position_info']['course']) && ($val['position_info']['course'] < 135)) {
                                $data['stop']['east'][] = $vehicle;
                            }
                            if ((135<=$val['position_info']['course']) && ($val['position_info']['course'] < 225)) {
                                $data['stop']['south'][] = $vehicle;
                            }
                            if ((225<=$val['position_info']['course']) && ($val['position_info']['course'] < 275)) {
                                $data['stop']['west'][] = $vehicle;
                            }
                        }

                    }

                }

            }
        }

        $this->ajaxReturn(array('code'=>$res['code'],'msg'=>$res['msg'],'data'=>$data));
    }

    public function typeGroupsLists($type = 'null')
    {
        $model = D('Groups');
        $res = $model->typeGroupsLists($this->context->loginuser->company_id, $type);
        $this->ajaxReturn(array('code' => $res['code'], 'msg' => $res['msg'], 'status_code' => $res['status_code'], 'data' => $res['data']));
    }

    /**
     * 百度地图坐标反查
     */
    private function getMapLocation($lng, $lat,$type='gaode')
    {

        if (!empty($lat) && !empty($lng)) {

            switch ($type) {
                case 'baidu': // 百度坐标系
                    $url = 'http://api.map.baidu.com/geocoder/v2/?ak=mbxCCTHApgXL9heLp0RMxOoY&location='.$lat.','.$lng.'&output=json&pois=1';
                    break;
                case 'gaode': // 高德坐标系
                    // 经纬度处理
                    $lng = explode('.', $lng)[0].'.'.mb_substr(explode('.', $lng)[1], 0, 6);
                    $lat = explode('.', $lat)[0].'.'.mb_substr(explode('.', $lat)[1], 0, 6);
                    $url = 'http://restapi.amap.com/v3/geocode/regeo?key=70f617e1b16c11e6e845ffe656d65d0f&location='.$lng.','.$lat.'&radius=1000&extensions=all&batch=false&roadlevel=0';
                    break;
                default:
                    return '未知';
            }

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($curl);
            curl_close($curl);

            if ($result) {
                $result = json_decode($result, true);
                switch ($type) {
                    case 'baidu': // 百度坐标系
                        return $result['result']['formatted_address'];
                    case 'gaode': // 高德坐标系
                        return $result['regeocode']['roads'][0]['name'] . '/' . $result['regeocode']['roads'][0]['direction'] . '/' . $result['regeocode']['roads'][0]['distance'] . '米';
                    default:
                        return '未知';
                }
            }
        }
        return '未知';
    }
}