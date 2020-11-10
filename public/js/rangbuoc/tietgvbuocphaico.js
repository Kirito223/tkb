var tbodySubjects, tbodyClass, tbodyConstraints;

function reloadgvthamgiagiangday() {
    chongvthamgiagiangday();
    loaddatadanhsachgvthamgiagiangday();
    var dataGrid = $("#girdtietgiaovienbuocphaico").dxDataGrid("instance");
    dataGrid.clearSelection();
    dataGrid.refresh();
}

function loaddatadanhsachgvthamgiagiangday() {
    tbodySubjects = document.getElementById("tbodySubjects");
    tbodyClass = document.getElementById("tbodyClass");
    tbodyConstraints = document.getElementById("tbodyConstraints");

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

    var listClassRoom = await loadListClassroom();
    var listSubject = await loadListSubject();
    var arrConstrainst = await loadListAssginmentOfTeacher($("#idgv").val());

    listClassRoom.forEach((item) => {
        let tr = document.createElement("tr");
        let checkbox = document.createElement("input");
        checkbox.setAttribute("type", "checkbox");
        let td = document.createElement("td");
        let span = document.createElement("span");
        span.appendChild(checkbox);
        let p = document.createElement("span");
        p.textContent = item.tenlop;
        span.appendChild(p);
        td.appendChild(span);
        tr.appendChild(td);
        tbodyClass.appendChild(tr);
    });

    listSubject.forEach((item) => {
        let tr = document.createElement("tr");
        let checkbox = document.createElement("input");
        checkbox.setAttribute("type", "checkbox");
        let td = document.createElement("td");
        let span = document.createElement("span");
        span.appendChild(checkbox);
        let p = document.createElement("span");
        p.textContent = item.tenmonhoc;
        span.appendChild(p);
        td.appendChild(span);
        tr.appendChild(td);
        tbodySubjects.appendChild(tr);
    });
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
