    <!-- add template model -->
    <div class="outer_model addTemplate fill" style="display: none;">
        <div class="inner_model bg-w width-50 rad-5">
            <div class="flex fill flex-s-btn pad-5">
                <h3 class="theme-text">Add SMS Template</h3>

                <button class="closeTemMode btn-pri btn-close"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
            </div>
            <div class="flex-c fill pad-10">
                <div class="flex-c">
                    <label for="smsTitle" class="theme-text-c">
                        SMS Title
                    </label>
                    <input type="text" id="smsTitle" class="input-s pad-5">

                    </input>
                </div>
                <div class="flex-c">
                    <label for="smsTarget" class="theme-text-c">
                        SMS Target
                    </label>
                    <select id="smsTarget" class="input-s pad-5">
                        <option class="pad-5" value=""> --select-- </option>
                        <option class="pad-5" value="All Customers">All Customers</option>
                        <option class="pad-5" value="Outstanding Cutomers">Outstanding Customers</option>
                        <option class="pad-5" value="Individual">Individual Customer</option>
                        <option class="pad-5" value="Individal Oustanding">Individial Outstanding Customer</option>
                    </select>
                </div>
                <div class="flex-c">
                    <label for="smsContent" class="theme-text-c">
                        SMS Content
                    </label>
                    <textarea id="smsContent" cols="30" rows="5" class="input-s pad-5"></textarea>
                </div>
                <div class="flex-c pad-5">
                    <h4 class="theme-text fill">Auto insert shortcuts</h4>
                    <span class="grid-3qe pad-5 pad-l-0 theme-text-c"><span class="w-500"> <i class="fa fa-arrow-right w-400" aria-hidden="true"></i> _name_</span> Insert Customer Name</span>
                    <span class="grid-3qe pad-5 pad-l-0 theme-text-c"><span class="w-500"> <i class="fa fa-arrow-right w-500" aria-hidden="true"></i> _outstanding_</span> Insert Outstanding Figure</span>
                    <span class="grid-3qe pad-5 pad-l-0 theme-text-c"><span class="w-500"> <i class="fa fa-arrow-right w-500" aria-hidden="true"></i> _paid_</span> Insert Paid Figure</span>

                </div>

                <div class="flex flex-centered fill">
                    <grid-2 class="grid-2 width-50">
                        <button class="closeTemMode btn-sec">CANCEL</button>
                        <button id="saveSMSTemplate" class="btn-pri">SAVE</button>
                    </grid-2>
                </div>
            </div>
        </div>
    </div>
    <!-- view smsTempsModel -->

    <div class="outer_model fill smsTempsModel" style="display: none;">
        <div class="inner_model width-50 bg-w rad-5 ">
            <div class="flex flex-s-btn pad-5 theme-border-b-2">
                <h3 class="theme-text">SMS Tempalates</h3>

                <button class="closeTempsModel btn-pri btn-close"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
            </div>

            <div class="flex-c fill pad-5">

                <?php
                if (mysqli_num_rows(fetchAllSmsTemps()) > 0) {
                    foreach (fetchAllSmsTemps() as $temp) {
                ?>
                        <div class="grid-2 fill">
                            <div class=""><?= $temp['sms_content'] ?></div>
                            <div class="grid-3qs">
                                <div class=""><?= $temp['sms_target'] ?></div>
                                <flex class="flex-centered">
                                    <div class="grid-3">
                                        <button class="btn-pri-o"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                                        <button class="closeTempsModel btn-pri-o"><i class="fas fa-edit    "></i></button>
                                        <button class="btn-pri-o"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                    </div>
                                </flex>

                            </div>
                        </div>
                <?php
                    }
                }

                ?>

            </div>
        </div>
    </div>

    <!-- Schuduled sms model -->
    <div class="outer_model fill smsSchedulModel" style="display: none;">
        <div class="inner_model width-50 bg-w rad-5">
            <div class="flex-c fill" id="addScheBox" style="display: none;">
                <div class="flex flex-s-btn fill pad-5">
                    <h3 class="theme-text">Schedule SMS</h3>
                    <button  class="btn-pri closeSceModel"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
                </div>
                <div class="flex-c fill pad-5">
                    <div class="flex-c fll">
                        <label for="tempSelected">Select a Template</label>
                        <select id="tempSelected" class="input-s pad-5">
                            <option value=""> --Select Template--</option>
                            <?php
                            if (mysqli_num_rows(fetchAllSmsTemps()) > 0) {
                                foreach (fetchAllSmsTemps() as $tempT) {
                            ?>
                                    <option id="sel_<?= $tempT['temp_id'] ?>" value="<?= $tempT['temp_id'] ?>"><?= $tempT['smsTitle'] ?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="grid-2 fill">
                        <div class="flex-c">
                            <label for="sendDate">Set Send Date</label>
                            <input class="input-s pad-5" type="date" id="sendDate">
                        </div>
                        <div class="flex-c">
                            <label for="sendTime">Set Send Date</label>
                            <input class="input-s pad-5" type="time" id="sendTime">
                        </div>

                    </div>
                    <div class="flex fill flex-centered">
                        <button id="addSchediledList" class="btn-sec width-50"><i class="fa fa-plus" aria-hidden="true"></i> ADD</button>
                    </div>
                </div>
            </div>
            <div class="flex fill flex-s-btn pad-5">
                <h3 class="theme-text">Scheduled SMS</h3>
                <span>
                <button id="addScTri" class="btn-pri"><i class="fa fa-plus" aria-hidden="true"></i></button>
                <button class="btn-pri closeSceModel"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
                </span>
            </div>
            <div class="fill flex-c pad-10 scroll-x" id="newSchedules">
           
            </div>

        </div>
    </div>