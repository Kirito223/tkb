@extends('master')
@section('title','Phân công giáo viên')
@section('content')

<dir class="row" style="padding: 0;margin: 0">
    <section class="col-md-12 col-xs-12">
        <section>
            <h3>KHAI BÁO DỮ LIỆU XẾP THỜI KHÓA BIỂU</h3>
        </section>
        <section>
            {{-- <button class="btn btn-sm btn-primary">Cập nhật phân công chuyên môn</button> --}}
            <button id="btnTaipccm" class="btn btn-sm btn-primary"><i class="fas fa-download"></i> Tải PCCCM</button>
            {{-- <button class="btn btn-sm btn-primary">Nhận PCCM từ TKB</button> --}}
            {{-- <select></select> --}}

        </section>
        <section style="margin-top: 10px;">
            <p style="font-weight: bold; color:red;"><i style="cursor: pointer;" id="showchitietchuapc"
                    class="fas fa-arrow-circle-right" aria-hidden="true"></i> Tổng số tiết chưa được phân công giáo viên
                dạy: <span id="tongsotietcp"></span></p>
            <section id="tableChuaphancong" class="hidden" style="overflow: scroll; height: 300px;">
                <table class="table table-bordered table-light">
                    <thead class="thead-default">
                        <tr>
                            <th rowspan="2">STT</th>
                            <th rowspan="2">Lớp</th>
                            <th style="text-align: center;" id="thMonhoc">Môn học</th>
                        </tr>
                        <tr id="trDanhsachmonhoc">

                        </tr>
                    </thead>
                    <tbody id="bangSotietchuaphancongs">

                    </tbody>
                </table>
            </section>
        </section>
        <section>
            <table class="table table-bordered table-light">
                <thead class="thead-default">
                    <tr>
                        <th rowspan="2">STT</th>
                        <th>Họ và tên</th>
                        <th>Tên</th>
                        <th>Bí danh</th>
                        <th rowspan="2">Số tiết</th>
                        <th rowspan="2">Chuyên môn</th>
                        <th rowspan="2">PCCM</th>
                        <th rowspan="2">Xóa</th>
                    </tr>
                    <tr>
                        <th><input id="timkiemHolot" class="input-sm form-control" type="text" /></th>
                        <th><input id="timkiemTen" class="input-sm form-control" type="text" /></th>
                        <th><input id="timkiemBidanh" class="input-sm form-control" type="text" /></th>
                    </tr>
                </thead>
                <tbody id="bangdanhsachphancong">

                </tbody>
            </table>
        </section>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="modelPhancong" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog xl-size" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Phân công chuyên môn</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <section class="col-md-12">
                                <section>
                                    <p id="lblPhacong">Phân công chuyên môn cho giáo viên</p>
                                    <h5 id="lblTongsotiet">Tổng số tiết:</h5>
                                </section>

                            </section>
                            <section class="col-md-3 col-xl-3" style="overflow-y: scroll; height: 500px;">
                                <table class="table table-bordered table-light ">
                                    <thead class="thead-inverse">
                                        <tr>
                                            <th>STT</th>
                                            <th>Môn</th>
                                            <th style="width: 10%;">Lớp dạy</th>
                                            <th>Chọn</th>
                                            <th>Số tiết</th>
                                        </tr>
                                    </thead>
                                    <tbody id="bangdanhsachmonpc">

                                    </tbody>
                                </table>
                            </section>
                            <section class="col-md-9 col-xl-9" style="overflow-y: scroll; height: 500px;">
                                <table class="table table-bordered table-light">
                                    <thead class="thead-inverse">
                                        <tr>
                                            <th>STT</th>
                                            <th>Lớp</th>
                                            <th>Chọn tất cả <input type="checkbox" id="chontatcaphancongmon" /></th>
                                            <th>Số tiết của môn</th>
                                            <th>Số tiết chưa phân công</th>
                                            <th>Giáo viên được phân công</th>
                                            <th>Xóa</th>
                                        </tr>
                                    </thead>
                                    <tbody id="bangdanhsachphancongchomonhoc">

                                    </tbody>
                                </table>
                            </section>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <section class="col-md-3">
                        <button id="btnXoatatcaPCCMtaimon" data-id="" data-giaovien="" class="btn btn-sm btn-danger">Xóa
                            tất cả phân công
                            chuyên môn</button>
                    </section>
                    <section class="col-md-9" style="text-align: right;">
                        <button type="button" class="btn btn-sm btn-primary" id="btncapnhatpccmgiaovien">Cập nhật PCCM
                            với giáo
                            viên:</button>
                        {{-- <button type="button" class="btn btn-sm btn-danger" id="btncapnhatpccmtatcagiaovien">Cập nhật
                            PCCM tất
                            cả
                            giáo viên</button> --}}
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Đóng</button>
                    </section>
                </div>
            </div>
        </div>
    </div>
</dir>

<style>
    input[type="text"],
    select {
        height: 28px;

    }

    .xl-size {
        min-width: 90%;
    }
</style>
<script type="module" src="{{asset('js\pccm\index.js')}}"></script>
@endsection