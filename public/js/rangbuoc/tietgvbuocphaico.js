function reloadgvthamgiagiangday() {
    chongvthamgiagiangday();
    loaddatadanhsachgvthamgiagiangday();
    var dataGrid = $("#girdtietgiaovienbuocphaico").dxDataGrid("instance");
    dataGrid.clearSelection();
    dataGrid.refresh();
}

function loaddatadanhsachgvthamgiagiangday() {
    var data = axios.get("gettietgvbuocphaico").then(function (response) {
        var data1 = response.data;
        // console.log(data1);
        var data2 = [];
        var lucky1 = data1.filter(function (items) {
            if (items.monhoc != "") {
                data2.push({
                    id: items.id,
                    ten: items.hovaten,
                    bidanh: items.bidanh,
                    thutuhienthi: items.thutuhienthi,
                    monhoc: items.monhoc,
                    rangbuoctietgvbuocphaico: items.rangbuoctietgvbuocphaico,
                });
            }
        });
        var data3 = [];
        var lucky2 = data2.filter(function (items1) {
            var magiaovien = items1.id;
            var data4 = [];
            data3.push({
                id: items1.id,
                ten: items1.ten,
                bidanh: items1.bidanh,
                thutuhienthi: items1.thutuhienthi,
                monhoc: data4,
                rangbuoctietgvbuocphaico: items1.rangbuoctietgvbuocphaico,
            });
            var datamh = items1.monhoc;
            var lucky3 = datamh.filter(function (items2) {
                if (magiaovien == items2.magiaovien) {
                    var malop = items2.malop;
                    var sotiet = items2.sotiet;
                    var mamonhoc = items2.mamonhoc;
                    var datalop = items2.danhsachlophoc;
                    var data5 = [];
                    data4.push({
                        id: items2.id,
                        malop: items2.malop,
                        magiaovien: items2.magiaovien,
                        tenmonhoc: items2.tenmonhoc,
                        lop: data5,
                    });
                    if (malop == datalop.id) {
                        data5.push({
                            id: datalop.id,
                            mamonhoc: mamonhoc,
                            tenlop: datalop.tenlop,
                            sotiet: sotiet,
                        });
                    }
                }
            });
        });
        // console.log(data3);
        var datas = data3.map(function (value, label) {
            let data = value;
            let stt = label + 1;
            var datas = Object.assign(data, { stt: stt.toString() });
            return datas;
        });
        chongvthamgiagiangday(datas);
    });
}

function chongvthamgiagiangday(datas) {
    // console.log(datas);

    $("#girdtietgiaovienbuocphaico").dxDataGrid({
        dataSource: datas,
        showBorders: true,
        paging: {
            pageSize: 10,
        },
        /* xap xep */
        sorting: {
            mode: "multiple",
        },
        /* loc du lieu */
        // filterRow: {
        // 	visible: true,
        // 	applyFilter: "auto"
        // },
        searchPanel: {
            visible: true,
            width: 240,
            placeholder: "Tìm kiếm...",
        },
        pager: {
            showPageSizeSelector: true,
            allowedPageSizes: [5, 10, 20],
            showInfo: true,
        },
        // editing: {
        // 	mode: "cell",
        // 	allowUpdating: true
        // },

        /*chon row*/
        // selection: {
        // 	mode: "single"
        // },
        /* co dan cot */
        allowColumnResizing: true,
        columnResizingMode: "widget",
        onEditorPreparing: function (e) {
            if (e.dataField == "stt" && e.parentType == "dataRow") {
                e.editorOptions.readOnly = true;
            }
            if (e.dataField == "ten" && e.parentType == "dataRow") {
                e.editorOptions.readOnly = true;
            }
            if (e.dataField == "bidanh" && e.parentType == "dataRow") {
                e.editorOptions.readOnly = true;
            }
            if (e.dataField == "monhoc" && e.parentType == "dataRow") {
                e.editorOptions.readOnly = true;
            }
        },
        columns: [
            {
                caption: "STT",
                dataField: "stt",
                width: 50,
            },
            {
                caption: "Tên",
                dataField: "ten",
            },
            {
                caption: "Bí danh(Tên hiển thị trên TKB)",
                dataField: "bidanh",
            },
            {
                caption: "Đăng ký tiết buộc phải có",
                // dataField: "bidanh",
                cellTemplate: function (container, options) {
                    var datarbtgvbpc = options.data.rangbuoctietgvbuocphaico;
                    var temp = datarbtgvbpc
                        .map(function (value) {
                            var buoi;
                            if (value.buoi == 0) {
                                buoi = "Sáng";
                            } else {
                                buoi = "Chiều";
                            }
                            return (
                                "Tiết " +
                                value.tiet +
                                " (Thứ " +
                                value.thu +
                                " - " +
                                buoi +
                                "; Mức: " +
                                value.mamucrangbuoc +
                                ")"
                            );
                        })
                        .join(", ");
                    // console.log(temp);
                    $("<div>")
                        .attr("id", "id")
                        // .attr("hidden","hidden")
                        .appendTo(container)
                        .text(temp)
                        .css("white-space", "normal")
                        .css("overflow-wrap", "break-word");

                    container.addClass("right");
                    $("<div>")
                        .dxButton({
                            stylingMode: "outlined",
                            text: "Chọn tiết",
                            type: "default",
                            width: 120,
                            onClick: function (e) {
                                $("#iddatarbtgvbpc").val(
                                    JSON.stringify(datarbtgvbpc)
                                );
                                dangkytietbuocphaico();
                                $("#modaldangkytietbuocphaicogv").modal("show");
                            },
                        })
                        .appendTo(container);
                },
            },
            {
                caption: "Hiển thị phân công CM",
                dataField: "monhoc",
                cellTemplate: function (element, info) {
                    var item = info.value;
                    var groups = {};
                    for (var i = 0; i < item.length; i++) {
                        // console.log(tenmonhoc);
                        var tenmonhoc = item[i].tenmonhoc;
                        if (!groups[tenmonhoc]) {
                            groups[tenmonhoc] = [];
                        }
                        groups[tenmonhoc].push(item[i].lop);
                    }
                    var data_new = [];
                    for (var tenmonhoc in groups) {
                        // console.log(idmonhoc);
                        data_new.push({
                            tenmonhoc: tenmonhoc,
                            lop: groups[tenmonhoc],
                        });
                    }
                    // console.log(data_new);
                    var temp = data_new
                        .map(function (value) {
                            var item1 = value.lop;
                            // console.log(item1);
                            var temp1 = item1
                                .map(function (value1) {
                                    // console.log(value1[0].sotiet);
                                    return (
                                        value1[0].tenlop +
                                        ": " +
                                        value1[0].sotiet
                                    );
                                })
                                .join(", ");
                            // console.log(temp1);
                            return value.tenmonhoc + " (" + temp1 + ")";
                        })
                        .join(", ");
                    // console.log(temp);
                    $("<div>")
                        .attr("id", "noidungpccmid")
                        // .attr("hidden","hidden")
                        .appendTo(element)
                        .text(temp)
                        .css("white-space", "normal")
                        .css("overflow-wrap", "break-word");
                    // return temp;
                },
            },
        ],
        onCellClick: function (e) {
            var data = e.data;
            $("#idgv").val(data.id);
            $("#idbidanhgv").text(data.bidanh);
        },
    });
}

async function loadListClassroom() {
    let result = await axios.get("getdanhsachlophoc").then((res) => {
        return res.data;
    });
    return result;
}
async function loadListSubject() {
    let result = await axios.get("getdanhsachmonhoc").then((res) => {
        return res.data;
    });
    return result;
}

async function loadListAssginmentOfTeacher(idTeacher) {
    let result = await axios
        .get(`/api/phanconggiaovien/listAssignment/${idTeacher}`)
        .then((res) => {
            return res.data.data;
        });
    return result;
}

async function dangkytietbuocphaico() {
    var iddatarbtgvbpc = $("#iddatarbtgvbpc").val();
    var datarbtgvbpc = JSON.parse(iddatarbtgvbpc);
    var chontietgvbuocphaico;
    if (datarbtgvbpc != "") {
        chontietgvbuocphaico = datarbtgvbpc;
    } else {
        chontietgvbuocphaico = [];
    }
    var data1 = [
        {
            idtiet: 1,
            tentiet: "Tiết 1",
            idbuoi: 0,
            tenbuoi: "Sáng",
        },
        {
            idtiet: 1,
            tentiet: "Tiết 1",
            idbuoi: 1,
            tenbuoi: "Chiều",
        },
        {
            idtiet: 2,
            tentiet: "Tiết 2",
            idbuoi: 0,
            tenbuoi: "Sáng",
        },
        {
            idtiet: 2,
            tentiet: "Tiết 2",
            idbuoi: 1,
            tenbuoi: "Chiều",
        },
        {
            idtiet: 3,
            tentiet: "Tiết 3",
            idbuoi: 0,
            tenbuoi: "Sáng",
        },
        {
            idtiet: 3,
            tentiet: "Tiết 3",
            idbuoi: 1,
            tenbuoi: "Chiều",
        },
        {
            idtiet: 4,
            tentiet: "Tiết 4",
            idbuoi: 0,
            tenbuoi: "Sáng",
        },
        {
            idtiet: 4,
            tentiet: "Tiết 4",
            idbuoi: 1,
            tenbuoi: "Chiều",
        },
        {
            idtiet: 5,
            tentiet: "Tiết 5",
            idbuoi: 0,
            tenbuoi: "Sáng",
        },
        {
            idtiet: 5,
            tentiet: "Tiết 5",
            idbuoi: 1,
            tenbuoi: "Chiều",
        },
    ];
    var datamrb = [
        {
            idmrb: 0,
            tenmuc: "Mức 0",
        },
        {
            idmrb: 1,
            tenmuc: "Mức 1",
        },
        {
            idmrb: 2,
            tenmuc: "Mức 2",
        },
        {
            idmrb: 3,
            tenmuc: "Mức 3",
        },
    ];
    var databh = [
        {
            idthu: 2,
            tenthu: "Thứ 2",
        },
        {
            idthu: 3,
            tenthu: "Thứ 3",
        },
        {
            idthu: 4,
            tenthu: "Thứ 4",
        },
        {
            idthu: 5,
            tenthu: "Thứ 5",
        },
        {
            idthu: 6,
            tenthu: "Thứ 6",
        },
        {
            idthu: 7,
            tenthu: "Thứ 7",
        },
    ];

    var listClassRoom = await loadListClassroom();

    var listSubject = await loadListSubject();
    var arrConstrainst = await loadListAssginmentOfTeacher($("#idgv").val());

    let bodyTable1 = document.getElementById("tietgvbuocphaico");
    let countdata1 = data1.length;
    for (let i = 0; i < countdata1; i++) {
        tr = document.createElement("tr");
        tr.appendChild(document.createElement("td"));
        tr.appendChild(document.createElement("td"));
        tr.appendChild(document.createElement("td"));
        tr.appendChild(document.createElement("td"));
        tr.appendChild(document.createElement("td"));
        tr.appendChild(document.createElement("td")); //Added for checkbox

        var checkbox = document.createElement("INPUT"); //Added for checkbox
        checkbox.type = "checkbox";
        checkbox.setAttribute("class", "chkbxctid");
        checkbox.setAttribute("id", i + 1);

        var selectList = document.createElement("select");
        selectList.setAttribute("class", "form-control input-xs");
        selectList.setAttribute("id", "idmrb" + (i + 1) + "");

        //Create and append the options
        for (var j = 0; j < datamrb.length; j++) {
            var option = document.createElement("option");
            option.value = datamrb[j].idmrb;
            option.text = datamrb[j].tenmuc;
            selectList.appendChild(option);
        }

        // Create select of buoi hoc
        var selectList1 = document.createElement("select");
        selectList1.setAttribute("id", "idthu" + (i + 1) + "");
        selectList1.setAttribute("class", "form-control input-sm");
        selectList1.setAttribute("type", "text");
        selectList1.setAttribute("multiple", "multiple");

        for (var k = 0; k < databh.length; k++) {
            var option = document.createElement("option");
            option.value = databh[k].idthu;
            option.text = databh[k].tenthu;
            selectList1.appendChild(option);
        }

        // Create select of classroom

        let selectClassroom = document.createElement("select");
        selectClassroom.setAttribute("id", "idlop" + (i + 1) + "");
        selectClassroom.setAttribute("class", "form-control input-sm");
        selectClassroom.setAttribute("type", "text");
        selectClassroom.setAttribute("multiple", "multiple");

        // Option of select class room

        for (let classroom = 0; classroom < listClassRoom.length; classroom++) {
            let option = document.createElement("option");
            option.value = listClassRoom[classroom].id;
            option.text = listClassRoom[classroom].tenlop;
            selectClassroom.appendChild(option);
        }

        // Create select of classroom

        let selectSubject = document.createElement("select");
        selectSubject.setAttribute("id", "idmon" + (i + 1) + "");
        selectSubject.setAttribute("class", "form-control input-sm");
        selectSubject.setAttribute("type", "text");
        selectSubject.setAttribute("multiple", "multiple");

        // filter subject of teacher from assignment of expertise table
        let arrSubjectfilter = [];

        arrConstrainst.forEach((item) => {
            let index = listSubject.findIndex((x) => x.id == item.mamonhoc);
            let findSubject = arrSubjectfilter.findIndex(
                (f) => f.id == item.mamonhoc
            );
            if (index > -1 && findSubject == -1) {
                arrSubjectfilter.push(listSubject[index]);
            }
        });

        //  Option of select subject
        for (let subject = 0; subject < arrSubjectfilter.length; subject++) {
            let option = document.createElement("option");
            option.value = arrSubjectfilter[subject].id;
            option.text = arrSubjectfilter[subject].tenmonhoc;
            selectSubject.appendChild(option);
        }

        tr.cells[0].appendChild(
            document.createTextNode(
                " " + data1[i].tentiet + "-" + data1[i].tenbuoi
            )
        );

        tr.cells[1].appendChild(selectList); // Select muc rang buoc
        tr.cells[2].appendChild(selectList1); // selectBuoihoc
        tr.cells[3].appendChild(selectClassroom); // select classroom
        tr.cells[4].appendChild(selectSubject); // select classroom
        tr.cells[5].appendChild(checkbox); // Checkbox
        bodyTable1.appendChild(tr);
    }
    for (var i = 0; i < countdata1 + 1; i++) {
        $("#idthu" + i + "").select2({ width: "100%" });
    }

    // set select 2 for select class room

    for (let index = 0; index < listClassRoom.length; index++) {
        $("#idlop" + index + "").select2({ width: "100%" });
    }

    for (let index = 0; index < listSubject.length; index++) {
        $("#idmon" + index + "").select2({ width: "100%" });
    }

    // Filter data and add item to chontietgvbuocphaico array
    if (chontietgvbuocphaico != "") {
        var table = document.getElementById("tietgvbuocphaico");
        var checkboxes = table.querySelectorAll("input[type=checkbox]");
        var idposition = [];
        var idmrb = [];
        var iddktgvbpc = [];
        var idthu1 = [];
        var idthu2 = [];
        var idthu3 = [];
        var idthu4 = [];
        var idthu5 = [];
        var idthu6 = [];
        var idthu7 = [];
        var idthu8 = [];
        var idthu9 = [];
        var idthu10 = [];

        // id class

        var idclass1 = [];
        var idclass2 = [];
        var idclass3 = [];
        var idclass4 = [];
        var idclass5 = [];
        var idclass6 = [];
        var idclass7 = [];
        var idclass8 = [];
        var idclass9 = [];
        var idclass10 = [];

        // id subject

        var idsubject1 = [];
        var idsubject2 = [];
        var idsubject3 = [];
        var idsubject4 = [];
        var idsubject5 = [];
        var idsubject6 = [];
        var idsubject7 = [];
        var idsubject8 = [];
        var idsubject9 = [];
        var idsubject10 = [];

        chontietgvbuocphaico.filter(function (items) {
            iddktgvbpc.push({ iddktgvbpc: items.id });
            if (items.buoi == 0 && items.tiet == 1) {
                idposition.push(1);
                idthu1.push(items.thu);
                idclass1.push(items.lop);
                idsubject1.push(items.mon);
                idmrb.push(items.mamucrangbuoc);
            } else if (items.buoi == 1 && items.tiet == 1) {
                idposition.push(2);
                idthu2.push(items.thu);
                idclass2.push(items.lop);
                idsubject2.push(items.mon);
                idmrb.push(items.mamucrangbuoc);
            } else if (items.buoi == 0 && items.tiet == 2) {
                idposition.push(3);
                idthu3.push(items.thu);
                idclass3.push(items.lop);
                idsubject3.push(items.mon);
                idmrb.push(items.mamucrangbuoc);
            } else if (items.buoi == 1 && items.tiet == 2) {
                idposition.push(4);
                idthu4.push(items.thu);
                idclass4.push(items.lop);
                idsubject4.push(items.mon);
                idmrb.push(items.mamucrangbuoc);
            } else if (items.buoi == 0 && items.tiet == 3) {
                idposition.push(5);
                idthu5.push(items.thu);
                idclass5.push(items.lop);
                idsubject5.push(items.mon);
                idmrb.push(items.mamucrangbuoc);
            } else if (items.buoi == 1 && items.tiet == 3) {
                idposition.push(6);
                idthu6.push(items.thu);
                idclass6.push(items.lop);
                idsubject6.push(items.mon);
                idmrb.push(items.mamucrangbuoc);
            } else if (items.buoi == 0 && items.tiet == 4) {
                idposition.push(7);
                idthu7.push(items.thu);
                idclass7.push(items.lop);
                idsubject7.push(items.mon);
                idmrb.push(items.mamucrangbuoc);
            } else if (items.buoi == 1 && items.tiet == 4) {
                idposition.push(8);
                idthu8.push(items.thu);
                idclass8.push(items.lop);
                idsubject8.push(items.mon);
                idmrb.push(items.mamucrangbuoc);
            } else if (items.buoi == 0 && items.tiet == 5) {
                idposition.push(9);
                idthu9.push(items.thu);
                idclass9.push(items.lop);
                idsubject9.push(items.mon);
                idmrb.push(items.mamucrangbuoc);
            } else if (items.buoi == 1 && items.tiet == 5) {
                idposition.push(10);
                idthu10.push(items.thu);
                idclass10.push(items.lop);
                idsubject10.push(items.mon);
                idmrb.push(items.mamucrangbuoc);
            }
        });

        if (idposition != "") {
            var idpositionnew = [...new Set(idposition)];
        }
        // Set checked checkbox select teacher
        for (var i = 0; i < checkboxes.length; i++) {
            var id = checkboxes[i].id;
            for (var j = 0; j < idpositionnew.length; j++) {
                if (id == idpositionnew[j]) {
                    checkboxes[i].checked = true;
                }
            }
        }

        if (idmrb != "") {
            var idmrbnew = [...new Set(idmrb)];
        }

        // set valeu selected level of constraint
        var m = 0;
        for (k = 0; k < idpositionnew.length; k++) {
            $("#idmrb" + idpositionnew[k] + "").val(idmrbnew[m]);
            m++;
        }

        if (idthu1 != "") {
            var idthu1new = [...new Set(idthu1)];
        }
        if (idthu2 != "") {
            var idthu2new = [...new Set(idthu2)];
        }
        if (idthu3 != "") {
            var idthu3new = [...new Set(idthu3)];
        }
        if (idthu4 != "") {
            var idthu4new = [...new Set(idthu4)];
        }
        if (idthu5 != "") {
            var idthu5new = [...new Set(idthu5)];
        }
        if (idthu6 != "") {
            var idthu6new = [...new Set(idthu6)];
        }
        if (idthu7 != "") {
            var idthu7new = [...new Set(idthu7)];
        }
        if (idthu8 != "") {
            var idthu8new = [...new Set(idthu8)];
        }
        if (idthu9 != "") {
            var idthu9new = [...new Set(idthu9)];
        }
        if (idthu10 != "") {
            var idthu10new = [...new Set(idthu10)];
        }
        var idthunew = [
            {
                idposition: 1,
                dataposition: idthu1new,
            },
            {
                idposition: 2,
                dataposition: idthu2new,
            },
            {
                idposition: 3,
                dataposition: idthu3new,
            },
            {
                idposition: 4,
                dataposition: idthu4new,
            },
            {
                idposition: 5,
                dataposition: idthu5new,
            },
            {
                idposition: 6,
                dataposition: idthu6new,
            },
            {
                idposition: 7,
                dataposition: idthu7new,
            },
            {
                idposition: 8,
                dataposition: idthu8new,
            },
            {
                idposition: 9,
                dataposition: idthu9new,
            },
            {
                idposition: 10,
                dataposition: idthu10new,
            },
        ];

        // set value selected thu
        for (var x = 0; x < idpositionnew.length; x++) {
            var idpst = idpositionnew[x];
            for (var z = 0; z < idthunew.length; z++) {
                if (idpst == idthunew[z].idposition) {
                    $("#idthu" + idpst + "")
                        .select2({ width: "100%" })
                        .val(idthunew[z].dataposition)
                        .trigger("change");
                }
            }
        }

        // set value selected classroom

        if (idclass1 != "") {
            var idclass1new = [...new Set(idclass1)];
        }
        if (idclass2 != "") {
            var idclass2new = [...new Set(idclass2)];
        }
        if (idclass3 != "") {
            var idclass3new = [...new Set(idclass3)];
        }
        if (idclass4 != "") {
            var idclass4new = [...new Set(idclass4)];
        }
        if (idclass5 != "") {
            var idclass5new = [...new Set(idclass5)];
        }
        if (idclass6 != "") {
            var idclass6new = [...new Set(idclass6)];
        }
        if (idclass7 != "") {
            var idclass7new = [...new Set(idclass7)];
        }
        if (idclass8 != "") {
            var idclass8new = [...new Set(idclass8)];
        }
        if (idclass9 != "") {
            var idclass9new = [...new Set(idclass9)];
        }
        if (idclass10 != "") {
            var idclass10new = [...new Set(idclass10)];
        }

        var idclassnew = [
            {
                idposition: 1,
                dataposition: idclass1new,
            },
            {
                idposition: 2,
                dataposition: idclass2new,
            },
            {
                idposition: 3,
                dataposition: idclass3new,
            },
            {
                idposition: 4,
                dataposition: idclass4new,
            },
            {
                idposition: 5,
                dataposition: idclass5new,
            },
            {
                idposition: 6,
                dataposition: idclass6new,
            },
            {
                idposition: 7,
                dataposition: idclass7new,
            },
            {
                idposition: 8,
                dataposition: idclass8new,
            },
            {
                idposition: 9,
                dataposition: idclass9new,
            },
            {
                idposition: 10,
                dataposition: idclass10new,
            },
        ];

        for (var x = 0; x < idpositionnew.length; x++) {
            var idpst = idpositionnew[x];
            for (var z = 0; z < idclassnew.length; z++) {
                if (idpst == idclassnew[z].idposition) {
                    $("#idlop" + idpst + "")
                        .select2({ width: "100%" })
                        .val(idclassnew[z].dataposition)
                        .trigger("change");
                }
            }
        }

        // set value selected subject
        if (idsubject1 != "") {
            var idsubject1new = [...new Set(idsubject1)];
        }
        if (idsubject2 != "") {
            var idsubject2new = [...new Set(idsubject2)];
        }
        if (idsubject3 != "") {
            var idsubject3new = [...new Set(idsubject3)];
        }
        if (idsubject4 != "") {
            var idsubject4new = [...new Set(idsubject4)];
        }
        if (idsubject5 != "") {
            var idsubject5new = [...new Set(idsubject5)];
        }
        if (idsubject6 != "") {
            var idsubject6new = [...new Set(idsubject6)];
        }
        if (idsubject7 != "") {
            var idsubject7new = [...new Set(idsubject7)];
        }
        if (idsubject8 != "") {
            var idsubject8new = [...new Set(idsubject8)];
        }
        if (idsubject9 != "") {
            var idsubject9new = [...new Set(idsubject9)];
        }
        if (idsubject10 != "") {
            var idsubject10new = [...new Set(idsubject10)];
        }

        var idsubjectnew = [
            {
                idposition: 1,
                dataposition: idsubject1new,
            },
            {
                idposition: 2,
                dataposition: idsubject2new,
            },
            {
                idposition: 3,
                dataposition: idsubject3new,
            },
            {
                idposition: 4,
                dataposition: idsubject4new,
            },
            {
                idposition: 5,
                dataposition: idsubject5new,
            },
            {
                idposition: 6,
                dataposition: idsubject6new,
            },
            {
                idposition: 7,
                dataposition: idsubject7new,
            },
            {
                idposition: 8,
                dataposition: idsubject8new,
            },
            {
                idposition: 9,
                dataposition: idsubject9new,
            },
            {
                idposition: 10,
                dataposition: idsubject10new,
            },
        ];

        for (var x = 0; x < idpositionnew.length; x++) {
            var idpst = idpositionnew[x];
            for (var z = 0; z < idsubjectnew.length; z++) {
                if (idpst == idsubjectnew[z].idposition) {
                    $("#idmon" + idpst + "")
                        .select2({ width: "100%" })
                        .val(idsubjectnew[z].dataposition)
                        .trigger("change");
                }
            }
        }

        $("#iddktgvbpc").val(JSON.stringify(iddktgvbpc));
    }
}
// Save data
$("#btnluutietgvbuocphaico").click(function () {
    var idgv = $("#idgv").val();
    var iddktgvbpc = $("#iddktgvbpc").val();
    var datatietnghi = [];
    var table = document.getElementById("tietgvbuocphaico");
    var checkboxes = table.querySelectorAll("input[type=checkbox]");
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked == true) {
            if (checkboxes[i].id == 1) {
                var idthu = [];
                var datathu = $("#idthu1").val();
                // filter and push data thu to idthu
                datathu.filter(function (items) {
                    idthu.push({ id: items });
                });

                // filter and push data lop to idlop

                let dataClass = $("#idlop1").val();
                let idClass = dataClass.map((item) => {
                    return { id: item };
                });

                // filter and push data mon to idmon

                let dataSubject = $("#idmon1").val();
                let idSubject = dataSubject.map((item) => {
                    return { id: item };
                });

                var idmrb = $("#idmrb1").val();
                datatietnghi.push({
                    idgv: idgv,
                    idtiet: 1,
                    idbuoi: 0,
                    idmrb: idmrb,
                    idthu: idthu,
                    idClass: idClass,
                    idSubject: idSubject,
                });
            } else if (checkboxes[i].id == 2) {
                var idthu = [];
                var datathu = $("#idthu2").val();
                datathu.filter(function (items) {
                    idthu.push({ id: items });
                });
                let dataClass = $("#idlop2").val();
                let idClass = dataClass.map((item) => {
                    return { id: item };
                });

                // filter and push data mon to idmon

                let dataSubject = $("#idmon2").val();
                let idSubject = dataSubject.map((item) => {
                    return { id: item };
                });

                var idmrb = $("#idmrb2").val();
                datatietnghi.push({
                    idgv: idgv,
                    idtiet: 1,
                    idbuoi: 1,
                    idmrb: idmrb,
                    idthu: idthu,
                    idClass: idClass,
                    idSubject: idSubject,
                });
            } else if (checkboxes[i].id == 3) {
                var idthu = [];
                var datathu = $("#idthu3").val();
                datathu.filter(function (items) {
                    idthu.push({ id: items });
                });
                let dataClass = $("#idlop3").val();
                let idClass = dataClass.map((item) => {
                    return { id: item };
                });

                // filter and push data mon to idmon

                let dataSubject = $("#idmon3").val();
                let idSubject = dataSubject.map((item) => {
                    return { id: item };
                });
                var idmrb = $("#idmrb3").val();
                datatietnghi.push({
                    idgv: idgv,
                    idtiet: 2,
                    idbuoi: 0,
                    idmrb: idmrb,
                    idthu: idthu,
                    idClass: idClass,
                    idSubject: idSubject,
                });
            } else if (checkboxes[i].id == 4) {
                var idthu = [];
                var datathu = $("#idthu4").val();
                datathu.filter(function (items) {
                    idthu.push({ id: items });
                });
                let dataClass = $("#idlop4").val();
                let idClass = dataClass.map((item) => {
                    return { id: item };
                });
                // filter and push data mon to idmon

                let dataSubject = $("#idmon4").val();
                let idSubject = dataSubject.map((item) => {
                    return { id: item };
                });
                var idmrb = $("#idmrb4").val();
                datatietnghi.push({
                    idgv: idgv,
                    idtiet: 2,
                    idbuoi: 1,
                    idmrb: idmrb,
                    idthu: idthu,
                    idClass: idClass,
                    idSubject: idSubject,
                });
            } else if (checkboxes[i].id == 5) {
                var idthu = [];
                var datathu = $("#idthu5").val();
                datathu.filter(function (items) {
                    idthu.push({ id: items });
                });
                let dataClass = $("#idlop5").val();
                let idClass = dataClass.map((item) => {
                    return { id: item };
                });
                // filter and push data mon to idmon

                let dataSubject = $("#idmon5").val();
                let idSubject = dataSubject.map((item) => {
                    return { id: item };
                });
                var idmrb = $("#idmrb5").val();
                datatietnghi.push({
                    idgv: idgv,
                    idtiet: 3,
                    idbuoi: 0,
                    idmrb: idmrb,
                    idthu: idthu,
                    idClass: idClass,
                    idSubject: idSubject,
                });
            } else if (checkboxes[i].id == 6) {
                var idthu = [];
                var datathu = $("#idthu6").val();
                datathu.filter(function (items) {
                    idthu.push({ id: items });
                });
                let dataClass = $("#idlop6").val();
                let idClass = dataClass.map((item) => {
                    return { id: item };
                });
                // filter and push data mon to idmon

                let dataSubject = $("#idmon6").val();
                let idSubject = dataSubject.map((item) => {
                    return { id: item };
                });
                var idmrb = $("#idmrb6").val();
                datatietnghi.push({
                    idgv: idgv,
                    idtiet: 3,
                    idbuoi: 1,
                    idmrb: idmrb,
                    idthu: idthu,
                    idClass: idClass,
                    idSubject: idSubject,
                });
            } else if (checkboxes[i].id == 7) {
                var idthu = [];
                var datathu = $("#idthu7").val();
                datathu.filter(function (items) {
                    idthu.push({ id: items });
                });

                let dataClass = $("#idlop7").val();
                let idClass = dataClass.map((item) => {
                    return { id: item };
                });
                // filter and push data mon to idmon

                let dataSubject = $("#idmon7").val();
                let idSubject = dataSubject.map((item) => {
                    return { id: item };
                });

                var idmrb = $("#idmrb7").val();
                datatietnghi.push({
                    idgv: idgv,
                    idtiet: 4,
                    idbuoi: 0,
                    idmrb: idmrb,
                    idthu: idthu,
                    idClass: idClass,
                    idSubject: idSubject,
                });
            } else if (checkboxes[i].id == 8) {
                var idthu = [];
                var datathu = $("#idthu8").val();
                datathu.filter(function (items) {
                    idthu.push({ id: items });
                });
                let dataClass = $("#idlop8").val();
                let idClass = dataClass.map((item) => {
                    return { id: item };
                });
                // filter and push data mon to idmon

                let dataSubject = $("#idmon8").val();
                let idSubject = dataSubject.map((item) => {
                    return { id: item };
                });
                var idmrb = $("#idmrb8").val();
                datatietnghi.push({
                    idgv: idgv,
                    idtiet: 4,
                    idbuoi: 1,
                    idmrb: idmrb,
                    idthu: idthu,
                    idClass: idClass,
                    idSubject: idSubject,
                });
            } else if (checkboxes[i].id == 9) {
                var idthu = [];
                var datathu = $("#idthu9").val();
                datathu.filter(function (items) {
                    idthu.push({ id: items });
                });
                let dataClass = $("#idlop9").val();
                let idClass = dataClass.map((item) => {
                    return { id: item };
                });
                // filter and push data mon to idmon

                let dataSubject = $("#idmon9").val();
                let idSubject = dataSubject.map((item) => {
                    return { id: item };
                });
                var idmrb = $("#idmrb9").val();
                datatietnghi.push({
                    idgv: idgv,
                    idtiet: 5,
                    idbuoi: 0,
                    idmrb: idmrb,
                    idthu: idthu,
                    idClass: idClass,
                    idSubject: idSubject,
                });
            } else if (checkboxes[i].id == 10) {
                var idthu = [];
                var datathu = $("#idthu10").val();
                datathu.filter(function (items) {
                    idthu.push({ id: items });
                });
                let dataClass = $("#idlop10").val();
                let idClass = dataClass.map((item) => {
                    return { id: item };
                });
                // filter and push data mon to idmon

                let dataSubject = $("#idmon10").val();
                let idSubject = dataSubject.map((item) => {
                    return { id: item };
                });
                var idmrb = $("#idmrb10").val();
                datatietnghi.push({
                    idgv: idgv,
                    idtiet: 5,
                    idbuoi: 1,
                    idmrb: idmrb,
                    idthu: idthu,
                    idClass: idClass,
                    idSubject: idSubject,
                });
            }
        }
    }

    console.log("datatietnghi", datatietnghi);

    axios
        .post("addrangbuoctietgvbuocphaico", {
            iddktgvbpc: iddktgvbpc,
            // idthu: idthu,
            datatietnghi: JSON.stringify(datatietnghi),
        })
        .then(function (response) {
            var data = response.data;
            Swal.fire({
                title: "Lưu",
                text: "Đã lưu thành công",
                icon: "success",
                confirmButtonText: "OK",
            });
            $("#modaldangkytietbuocphaicogv").modal("hide");
            $("#modaldangkytietbuocphaicogv").on(
                "hidden.bs.modal",
                function () {
                    $(this).find("#formthemmoitietgvbuocphaico")[0].reset();
                    // $(this).find('#formthemmoirangbuoctietcodinhtiethoc').trigger("reset");
                }
            );
            reloadgvthamgiagiangday();
        });
});

$("#btndongdangkytietbuocphaicogv").on("click", function () {
    $("#modaldangkytietbuocphaicogv").on("hidden.bs.modal", function (e) {
        $(this).find("#formthemmoitietgvbuocphaico")[0].reset();
        $("#tablechontietgvbuocphaico>tbody").empty();
    });
});

jQuery(document).ready(function () {
    jQuery("#modaldangkytietbuocphaicogv").on("hidden.bs.modal", function (e) {
        $(this).find("#formthemmoitietgvbuocphaico")[0].reset();
        $("#tablechontietgvbuocphaico>tbody").empty();
    });
});
