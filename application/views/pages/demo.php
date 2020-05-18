<div class="tab-outline">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <!-- <li class="nav-item">
                                <a data-i="<?php print_r($processes[0]['process_id']); ?>" class="nav-link active" id="tab-outline-0" data-toggle="tab" href="#outline-0" role="tab" aria-controls="tab" aria-selected="true">
                                    <?php print_r($processes[0]['process_description']); ?></a>
                                    <div data-id="<?php print_r($processes[0]['process_id']); ?>" class="arrow-down hide"></div>
                            </li> -->
                            <?php for ($i = 1; $i < count($processes); $i++) { ?>
                                <li class="nav-item">
                                    <a class="nav-link" id="tab-outline-<?php echo $i; ?>" data-toggle="tab" href="#outline-<?php echo $i ?>" role="tab" aria-controls="tab<?php echo $i ?>" aria-selected="true"> <?php print_r($processes[$i]['process_description']); ?></a>
                                    <div class="arrow-down hide"></div>
                                </li>
                            <?php } ?>

                        </ul>
                        <div class="tab-content my-4" id="myTabContent2">
                            <div class="tab-pane fade show active" id="outline-0" role="tabpanel" aria-labelledby="tab-outline-0">
                                <?php
                                $tableName = 'sub_process_master';
                                $condition = array('process_id' => $processes[0]['process_id']);
                                $subprocess = $this->MainModel->selectAllFromWhere($tableName, $condition); ?>
                                <div class="row">
                                    <div class="col-xl-5 col-lg-4 col-md-6 col-sm-12 col-12">
                                        <h5>Sub-Process(Option)</h5>
                                        <div class="card border-1">
                                            <div class="card-body">
                                                <ul class="subprocess-item" data-id='select-option<?php echo $processes[0]['process_id']?>'>
                                                    <?php if (!empty($subprocess)) {
                                                        foreach ($subprocess as $item) {
                                                    ?>
                                                            <li class="sub-item remove-item" data-id='<?php echo $processes[0]['process_id']?>'>
                                                                <?php echo $item['sub_process_description'] ?>
                                                            </li>
                                                    <?php }
                                                    } ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-4 col-md-6 col-sm-12 col-12">
                                        <div class='backword-forword'>
                                            <div class="col-sm-6 col-md-4 col-lg-3 f-icon"><i class="fas fa-forward"></i></div>
                                            <div class="col-sm-6 col-md-4 col-lg-3 f-icon"><i class="fas fa-backward"></i> </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-5 col-lg-4 col-md-6 col-sm-12 col-12">
                                        <h5 class="">Selected Sub-Process</h5>
                                        <div class="card">
                                            <div class="card-body">
                                                <ul class="selected-subprocess" id="<?php echo $processes[0]['process_id']?>">
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- print_r($subprocess);
                                    ?> -->

                                </div>
                                <!-- <a href="#" class="btn btn-secondary"></a> -->
                            </div>
                            <?php for ($i = 1; $i < count($processes); $i++) { ?>
                                <div class="tab-pane fade" id="outline-<?php echo $i ?>" role="tabpanel" aria-labelledby="tab-outline-<?php echo $i ?>">
                                    <?php
                                    $tableName = 'sub_process_master';
                                    $condition = array('process_id' => $processes[$i]['process_id']);
                                    $subprocess = $this->MainModel->selectAllFromWhere($tableName, $condition); ?>
                                    <div class="row">
                                        <div class="col-xl-5 col-lg-4 col-md-6 col-sm-12 col-12">
                                            <div class="card">
                                                <h5 class="card-header">Sub-Process(Option)</h5>
                                                <div class="card-body">
                                                    <ul class="subprocess-item select-option" id='select-option<?php echo $processes[$i]['process_id']?>'>
                                                        <?php if (!empty($subprocess)) {
                                                            foreach ($subprocess as $item) {
                                                        ?>
                                                                <li class="sub-item remove-item" data-id="<?php echo $processes[$i]['process_id']?>">
                                                                    <?php echo $item['sub_process_description'] ?>
                                                                </li>
                                                        <?php }
                                                        } ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-2 col-lg-4 col-md-6 col-sm-12 col-12">
                                            <div class='backword-forword'>
                                                <div class="col-sm-6 col-md-4 col-lg-3 f-icon"><i class="fas fa-forward"></i></div>
                                                <div class="col-sm-6 col-md-4 col-lg-3 f-icon"><i class="fas fa-backward"></i> </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-5 col-lg-4 col-md-6 col-sm-12 col-12">
                                            <h5 class="">Selected Sub-Process</h5>
                                            <div class="card">
                                                <div class="card-body selected-sub">
                                                    <ul class="selected-subprocess" id="<?php echo $processes[$i]['process_id']?>">
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>




                    <!--     if (items.length != 0) {
        let currentprocess;
        len = items.length;
        items.forEach(e => {

            // console.log(e)
            // console.log(e.processname);
            // console.log(e.spname);

            // if (currentprocess != e.processname) {
            //     currentprocess = e.processname;
            //     list.push(e.spname);
            //     body += `
            //         <td scope="col">${e.spname}</td>`;
            //     // cpc++
            //     len -= 1
            // }
            body += `
                    <td scope="col">${e.spname}</td>`;
        });

        body += `</tr>`;
        // if (len > 0) {
        //     body += `</tr><tr>`;
        //     // if (items.length != 0) {
        //     let currentprocess;
        //     // console.log(list);
        //     items.forEach(e => {
        //         // console.log(e.spname)
        //         // console.log(e.processname);
        //         if (currentprocess != e.processname) {
        //             currentprocess = e.processname;

        //             for(let i=0; i<list.length;i++){
        //                 console.log(list[i]);
        //                 if(list[i]!=e.spname){

        //                     // console.log(e.spname);
        //                 }
        //             }


        //             // let r = list.find(el => {
        //             //         if (el == e.spname) {
        //             //             return true;
        //             //         } else {
        //             //             return false;
        //             //         }
        //             //         // e.spname
        //             //     });
        //             // console.log(r);
        //             // if (r == false) {
        //             //     body += `
        //             // <td scope="col">${e.spname}</td>`;
        //             // }
        //         }

        //     });
        // }
        // }
        // body += `</tr>`;
        // console.log(list);

        // ssp += `<tr>`;
        // if (currentprocess != e.processname) {
        //     currentprocess = e.processname;
        //     ssp += `<tr>
        //         <th scope="col">${currentprocess}</th>
        //         </tr>
        // `;
        // }
        // ssp += ` <tr>
        //      <td>${e.spname}</td>
        //      </tr>
        //     `;
        // ssp += `</tr>`;
        // });
        // console.log(cpc);

    }
 -->