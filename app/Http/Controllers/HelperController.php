<?php

namespace App\Http\Controllers;

use App\Libraries\Repositories\SettingTrainingRepositoryEloquent;

class HelperController extends Controller
{
    protected $userId;
    protected $DIST;
    protected $T;

    protected $VO2;
    protected $PERCENT_MAX;
    protected $vDOT;

    protected $TARGET;

    protected $settingTrainingRepository;

    public function __construct(SettingTrainingRepositoryEloquent $settingTrainingRepository)
    {
        $this->userId = \Auth::id();

        // dd('check id', $this->userId);

        $this->settingTrainingRepository = $settingTrainingRepository;
    }

    public function convertKMtoMeters($km = null)/*  () => isset($km) ? ($km * 1000) : null; */
    {
        $this->DIST = isset($km) ? ($km * 1000) : 0;
    }

    public function convertTimeToMinutes($time = null)
    {
        if (isset($time)) {
            $timesArr = explode(':', $time);
            $hr = $timesArr[0] ?? 0;
            $min = $timesArr[1] ?? 0;
            $sec = $timesArr[2] == "00" ? 0 : 1;
            $totalMinutes = ((((int) ($hr)) ?? 0) * 60)
                + ((((int) ($min)) ?? 0))
                + (int) $sec;
            $this->T = $totalMinutes;
            // return $totalMinutes;
        } else {
            $this->T = 0;
        }
        // return 0;
        // let timeArray = raceTime.components(separatedBy: ":")
        //                     let totalHrs = timeArray[0]
        //                     let totalMins = timeArray[1]
        //                     let totalSec = timeArray[2] == "00" ? 0 : 1
        //                     let totalTime = (Int(totalHrs) ?? 0 * 60) + (Int(totalMins) ?? 0) + totalSec
        // obj.mainModelView.raceTime = Double(totalTime)
    }

    /** 
     * * Start Here
     * Calculate vDOT For common_programs_weeks_laps table APP user only
     */
    public function calculate_V_DOT($input = null)
    {
        $settingTrainingDetails = $this->settingTrainingRepository->getDetailsByInput([
            'user_id' => $this->userId,
            'relation' => ["race_distance_detail"],
            'first' => true
        ]);

        /** check for race distance is exists or not */
        if (isset($settingTrainingDetails) && isset($settingTrainingDetails->race_distance_detail)) {
            $kmNumber = explode(" ", $settingTrainingDetails->race_distance_detail->name);

            $this->convertKMtoMeters($kmNumber[0]); // convert KM to METERs
            $this->convertTimeToMinutes($settingTrainingDetails->race_time); // convert Time To Minutes
        }

        # 1. calculate step one and generate VO2
        $this->calculateFirstStepOf_V_DOT();

        # 2. calculate step two and generate PERCENT_MAX
        $this->calculateSecondStepOf_V_DOT();

        # 3. calculate step three and generate V_DOT
        $this->calculateThirdStepOf_V_DOT();

        # 4. calculate step four and speed to condition wise compare with laps vDOT added from admin side in common laps weeks
        $this->calculateFourthStepOf_V_DOT($input);

        # all Calculation Done HERE
        // dd(
        //     'preset ',
        //     "VO2 = " .  $this->VO2,
        //     "PERCENT_MAX = " . $this->PERCENT_MAX,
        //     "vDOT = " .  $this->vDOT,
        //     "TARGET E = " . $this->TARGET
        // );

        $input['speed'] = $this->TARGET;
        return $input;
    }

    /**
     ** Step => 1
     * 
     * calculateFirstStepOf_V_DOT
     *
     * @param  mixed $input
     *
     * @return void
     */
    public function calculateFirstStepOf_V_DOT($input = null)
    {
        $this->VO2 = -4.6 + 0.182258
            * ($this->DIST / $this->T)
            + 0.000104
            * ($this->DIST / $this->T)
            ^ 2;
    }

    /**
     ** Step => 2
     * 
     * calculateSecondStepOf_V_DOT 
     *
     * @param  mixed $input
     *
     * @return void
     */
    public function calculateSecondStepOf_V_DOT($input = null)
    {
        $this->PERCENT_MAX = 0.8 + 0.1894393
            * exp(-0.012778 * $this->T)
            + 0.2989558
            * exp(-0.1932605 * $this->T);
    }

    /**
     ** Step => 3 
     * 
     * calculateThirdStepOf_V_DOT => ( Step 1 / Step 2 )
     *
     * @param  mixed $input
     *
     * @return void
     */
    public function calculateThirdStepOf_V_DOT($input = null)
    {
        $this->vDOT = $this->VO2 / $this->PERCENT_MAX;
    }

    /**
     ** Step => 4 
     * 
     * calculateFourthStepOf_V_DOT => 
     *
     * @param  mixed $input
     *
     * @return void
     */
    public function calculateFourthStepOf_V_DOT($input = null)
    {
        $input = !!!is_array($input) ? $input : $input;

        if (stripos($input['vdot'], 'E') !== false) {
            $this->calculateForEvDot();
        } else if (stripos($input['vdot'], 'M') !== false) {
            $this->calculateForMvDot();
        } else  if (stripos($input['vdot'], 'I') !== false) {
            $this->calculateForIvDot();
        } else  if (stripos($input['vdot'], 'R') !== false) {
            $this->calculateForRvDot();
        } else  if (stripos($input['vdot'], 'T') !== false) {
            $this->calculateForTvDot();
        }
    }

    /**
     * calculateForTvDot => Calculate E
     *
     * @return void
     */
    public function calculateForEvDot()
    {
        $this->TARGET = ($this->DIST * 2 * 0.000104)
            / (-0.182258
                +
                sqrt(
                    0.182258 ^ 2 - 4 * 0.000104 * (-4.6 - 0.67 * $this->vDOT)
                ));
    }

    /**
     * calculateForTvDot => Calculate M
     *
     * @return void
     */
    public function calculateForMvDot()
    {
        $this->TARGET = ($this->DIST * 2 * 0.000104)
            / (-0.182258
                +
                sqrt(
                    0.182258 ^ 2 - 4 * 0.000104 * (-4.6 - 0.67 * $this->vDOT)
                ));
    }

    /**
     * calculateForTvDot => Calculate I
     *
     * @return void
     */
    public function calculateForIvDot()
    {
        $this->TARGET = ($this->DIST * 2 * 0.000104)
            / (-0.182258
                +
                sqrt(
                    0.182258 ^ 2 - 4 * 0.000104 * (-4.6 - 0.975 * $this->vDOT)
                ));
    }
    /**
     * calculateForTvDot => Calculate R
     *
     * @return void
     */
    public function calculateForRvDot()
    {
        $this->TARGET = ($this->DIST * 2 * 0.000104)
            / (-0.182258
                +
                sqrt(
                    0.182258 ^ 2 - 4 * 0.000104 * (-4.6 - 0.975 * $this->vDOT)
                ));
    }


    /**
     * calculateForTvDot => Calculate T
     *
     * @return void
     */
    public function calculateForTvDot()
    {
        $this->TARGET = ($this->DIST * 2 * 0.000104)
            / (-0.182258
                +
                sqrt(
                    0.182258 ^ 2 - 4 * 0.000104 * (-4.6 - 0.88 * $this->vDOT)
                ));
    }
}
