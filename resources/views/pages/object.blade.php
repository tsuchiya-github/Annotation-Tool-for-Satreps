@extends('layouts.app')

@section('content')

    @if(count($objects) > 0)

    <script>
        $(function(){
            $('#on').click(function(){
                $("a.page-link").on('click', myHandler);

            });
            $('#off').click(function(){
                $("a.page-link").off('click', myHandler);

            });

            $('#on_finish').click(function(){
                $("a.finish").on('click', myHandler);

            });
            $('#off_finish').click(function(){
                $("a.finish").off('click', myHandler);

            });

        });
        function myHandler(e){
            e.preventDefault();
        }
        
        $(window).on('load',function(){
            // DOM生成後に処理したい内容を書く。
            document.getElementById('on').click(); //リンク無効
            document.getElementById('on_finish').click();
            $('a.page-link').balloon({ position: "top" });
        });
    </script>
        @foreach($objects as $object)
                <div class=well>
                    <div class="progress">
                        <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="1"
                    aria-valuemin="1" aria-valuemax="15" style="width:{{$objects->currentPage() * 6.66}}%">
                          {{$objects -> currentPage()}} / 15
                        </div>
                      </div>
                        <h4>image_name : {{{ $image_name=$object->image_name }}}</h4>
                        <h4>Your Status : {{ $gender = Session::get('seibetu') }} / {{ $age = Session::get('age') }} / {{ $nationality = Session::get('nationality') }}</h4>
                        <div class="alert alert-danger" role="alert">
                          <strong>Use your mouse to crop only one object that has the greatest or least impact on QoL. The cropped object is displayed next to it.<br>If you want to deselect, click once on the image.</strong>
                        </div>
                        <img id="img_source" style="display:none;" src="{{$object->image_path}}" width="500px" height="auto" />

                      {{-- <img id="img_source" style="display:none;" src="/picture/lena.png" width="800px" height="auto" /> --}}
                    <canvas id="SrcCanvas" onmousedown="OnMousedown(event);" onmousemove="OnMousemove(event);" onmouseup="OnMouseup(event);" width="image.width" height="image.height"></canvas>
                    <canvas id="RecCanvas"></canvas>
                    <div class="row">
                      <div class="col-md-6">
                      </div>
                      <div class="col-md-6">
                      </div>
                    </div>
                    <h4><span class="label label-success"></span></h4>
                    <hr>


                    <div class="row">
                      <div class="col-md-4">

                        <h4>Value of BoundingBox:<div id="out1"></div><div id="out2"></div></h4>
                      </div>
                      <div class="col-md-8">
                        <form action="/insert_data" method="post">
                          {{-- CSRF対策 --}}
                          {{ csrf_field() }}
                              <h4><li>物体の名称(Object name)</li></h4>
                                <select id="object_name" name="image_type" required>
                                    <option value="" selected="selected">-Please select-</option>
                                    @foreach($type_of_image as $type_of_images)
                                        <option value="{{$type_of_images->image_type}}">{{$type_of_images->image_type}}</option>
                                    @endforeach
                                </select>
                              <h4><li>快適度の決定指標(Indicators)</li></h4>
                                <select id="factors" name="factors" required>
                                    <option value="" selected="selected">-Please select-</option>
                                    @foreach($factors as $factor)
                                        <option value="{{$factor->factor}}">{{$factor->factor}}</option>
                                    @endforeach
                                </select>
                              <h4><li>快適度(Comfort level)</li></h4>
                              <label for="comfortable5"><input type="radio" name="comfortable" value="5" id="comfortable5" required>Extremely satisfied(5)&nbsp;</label>
                              <label for="comfortable4"><input type="radio" name="comfortable" value="4" id="comfortable4" required>Very satisfied(4)&nbsp;</label>
                              <label for="comfortable3"><input type="radio" name="comfortable" value="3" id="comfortable3" required>Neutral(3)&nbsp;</label>
                              <label for="comfortable2"><input type="radio" name="comfortable" value="2" id="comfortable2" required>Slightly not satisfied(2)&nbsp;</label>
                              <label for="comfortable1"><input type="radio" name="comfortable" value="1" id="comfortable1" required>Not at all satisfied(1)&nbsp;</label>
                      </div>
                      <hr>
                        {{-- hiddenでimage_name,image_path,rect~をpostする --}}
                        <input type="hidden" name="gender" value="{{$gender}}">
                        <input type="hidden" name="age" value="{{ $age = Session::get('age') }}">
                        <input type="hidden" name="nationality" value="{{ $nationality = Session::get('nationality') }}">

                        <input type="hidden" name="image_name" value="{{ $image_name=$object->image_name }}">
                        <input type="hidden" name="image_path" value="{{ $image_path=$object->image_path }}">
                        <input type="hidden" id="rect_sx" name="rect_sx" value="">
                        <input type="hidden" id="rect_sy" name="rect_sy" value="">
                        <input type="hidden" id="rect_ex" name="rect_ex" value="">
                        <input type="hidden" id="rect_ey" name="rect_ey" value=""><br>
                        <button type="submit" id="tsuchiya" class="btn btn-primary pull-right" onclick="disabled = true;">Submit</button>
                        </form>
                      </div>
                    <script>
                        // キャンバス
                        var src_canvas; 
                        var src_ctx;
                          
                        // イメージ
                        var image;
                          
                        // 矩形用
                        var MIN_WIDTH  = 3;
                        var MIN_HEIGHT = 3;
                        
                        var rect_MousedownFlg = false;
                        var rect_sx = 0;
                        var rect_sy = 0;
                        var rect_ex = 0;
                        var rect_ey = 0;
                        
                        window.onload = function () {
                          
                          src_canvas = document.getElementById("SrcCanvas");
                          src_ctx = src_canvas.getContext("2d");    
                          
                          rec_canvas = document.getElementById("RecCanvas");
                          rec_ctx = rec_canvas.getContext("2d");
                          rec_canvas.width = rec_canvas.height = 1;   
                            
                          image = document.getElementById("img_source");       
                        
                          src_canvas.width  = image.width;
                          src_canvas.height = image.height;
                          image.width = 400;  // 横幅を400pxにリサイズ
                          image.height = src_canvas.height * (image.width / src_canvas.width); // 高さを横幅の変化割合に合わせる

                          // キャンバスに画像を描画
                          src_ctx.drawImage(image,0,0); 
                        }
                          
                        // 色の反転
                        function getTurningAround(color) {
                          
                          // 灰色は白にする 
                          if(color >= 88 && color <= 168){
                            return 255;
                          // 色を反転する  
                          }else{
                            return 255 - color;
                          }
                        }
                          
                        function OnMousedown(event) {
                          
                          rect_MousedownFlg = true;
                          
                          // 座標を求める
                          var rect = event.target.getBoundingClientRect();
                          rect_sx = rect_ex = event.clientX - rect.left;
                          rect_sy = rect_ey = event.clientY - rect.top; 
                          rect_sx = Math.round(rect_sx);
                          rect_sy = Math.round(rect_sy);
                          
                          // 矩形の枠色を反転させる  
                          var imagedata = src_ctx.getImageData(rect_sx, rect_sy, 1, 1);   
                          src_ctx.strokeStyle = 'rgb(' + getTurningAround(imagedata.data[0]) +
                                                    ',' + getTurningAround(imagedata.data[1]) + 
                                                    ',' + getTurningAround(imagedata.data[2]) + ')';  
                          // 線の太さ                         
                          src_ctx.lineWidth = 2; 
                          
                          // 矩形の枠線を点線にする
                          src_ctx.setLineDash([2, 3]);                             
                        }
                          
                        function OnMousemove(event) {
                          
                          if(rect_MousedownFlg){
                            
                            // 座標を求める
                            var rect = event.target.getBoundingClientRect();
                            rect_ex = event.clientX - rect.left;
                            rect_ey = event.clientY - rect.top; 
                            rect_ex = Math.round(rect_ex);
                            rect_ey = Math.round(rect_ey);
                            
                            // 元画像の再描画
                            src_ctx.drawImage(image,0,0);  
                            
                            // 矩形の描画
                            src_ctx.beginPath();
                          
                              // 上
                              src_ctx.moveTo(rect_sx,rect_sy);
                              src_ctx.lineTo(rect_ex,rect_sy);
                          
                              // 下
                              src_ctx.moveTo(rect_sx,rect_ey);
                              src_ctx.lineTo(rect_ex,rect_ey);
                          
                              // 右
                              src_ctx.moveTo(rect_ex,rect_sy);
                              src_ctx.lineTo(rect_ex,rect_ey);
                          
                              // 左
                              src_ctx.moveTo(rect_sx,rect_sy);
                              src_ctx.lineTo(rect_sx,rect_ey);
                          
                            src_ctx.stroke();
                        //    document.open();
                        //     document.write(rect_ex);
                        //     document.close(); 

                          }
                        }
                          
                        function OnMouseup(event) {
                          
                          // キャンバスの範囲外は無効にする    
                          if(rect_sx === rect_ex && rect_sy === rect_ey){
                            // 初期化
                            src_ctx.drawImage(image,0,0); 
                            rect_sx = rect_ex = 0;
                            rect_sy = rect_ey = 0;   
                            rec_canvas.width = rec_canvas.height = 1; 
                          }
                          
                          // 矩形の画像を取得する
                          if(rect_MousedownFlg){

                            if(rect_ex < rect_sx) {
                              rep = rect_ex;
                              rect_ex = rect_sx;
                              rect_sx = rep
                            }

                            if(rect_ey < rect_sy) {
                              rep = rect_ey;
                              rect_ey = rect_sy;
                              rect_sy = rep;
                            }
                            
                            // 矩形のサイズ
                            rec_canvas.width  = Math.abs(rect_sx - rect_ex);
                            rec_canvas.height = Math.abs(rect_sy - rect_ey);
                            
                            // 指定のサイズ以下は無効にする[3x3]
                            if(!(rec_canvas.width >= MIN_WIDTH && rec_canvas.height >= MIN_HEIGHT)){
                              // 初期化
                              src_ctx.drawImage(image,0,0); 
                              rect_sx = rect_ex = 0;
                              rect_sy = rect_ey = 0; 
                              rec_canvas.width = rec_canvas.height = 1;
                            }else{
                              // 矩形用キャンバスへ画像の転送
                              rec_ctx.drawImage(image,
                                                Math.min(rect_sx,rect_ex),Math.min(rect_sy,rect_ey),  
                                                Math.max(rect_sx - rect_ex,rect_ex - rect_sx),Math.max(rect_sy - rect_ey ,rect_ey - rect_sy),
                                                0,0,rec_canvas.width,rec_canvas.height);  
                            }
                          }
                          
                          rect_MousedownFlg = false;
                        }
                          
                        function onDragOver(event){ 
                          event.preventDefault(); 
                        } 
                          
                        function onDrop(event){
                          onAddFile(event);
                          event.preventDefault(); 
                        }  
                          
                        // ユーザーによりファイルが追加された  
                        function onAddFile(event) {
                          var files;
                          var reader = new FileReader();
                          
                          if(event.target.files){
                            files = event.target.files;
                          }else{ 
                            files = event.dataTransfer.files;   
                          }    
                          
                          // ファイルが読み込まれた
                          reader.onload = function (event) {
                            
                            // イメージが読み込まれた
                            image.onload = function (){
                              src_canvas.width  = image.width;
                              src_canvas.height = image.height;
                          src_canvas.width  = image.width;
                          src_canvas.height = image.height;
                          image.width = 400;  // 横幅を400pxにリサイズ
                          image.height = src_canvas.height * (image.width / src_canvas.width); // 高さを横幅の変化割合に合わせる

                                
                              // キャンバスに画像を描画
                              src_ctx.drawImage(image,0,0); 
                            };      
                                
                            // イメージが読み込めない
                            image.onerror  = function (){
                              alert('このファイルは読み込めません。');  
                            };
                          
                            image.src = reader.result;       
                          };
                          
                          if (files[0]){    
                            reader.readAsDataURL(files[0]); 
                            document.getElementById("inputfile").value = '';
                          } 
                        }


                        $('#SrcCanvas').mouseup(function() {

                            $.ajaxSetup({
                            headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                            });

                            $.when(
                              $.ajax({
                                    url:'/ajax',
                                    type:'POST',
                                    data:{
                                    // password:$("#ajaxText").val()
                                    //login_id:$("#login_id").val()
                                        'rect_sx' : rect_sx,
                                        'rect_sy' : rect_sy,
                                        'rect_ex' : rect_ex,
                                        'rect_ey' : rect_ey,
                                    },
                                    datatype:'json',
                                    success: function(json) {
                                        // alert("矩形左上の座標(x, y)=("+json[0]+", "+json[1]+")\n矩形右下の座標(x, y)=("+json[2]+", "+json[3]+")" );
                                        $("#out1").text("Top left (x, y)=("+json[0]+", "+json[1]+")" );
                                        $("#out2").text("Bottom right (x, y)=("+json[2]+", "+json[3]+")" );

                                    //window.location.href = './dashboard';
                                    },
                                    error: function(json) {
                                        alert("失敗");
                                    return false;
                                    },
                                })
                            ).done(function(){ 
                                document.getElementById("rect_sx").value=rect_sx;
                                document.getElementById("rect_sy").value=rect_sy;
                                document.getElementById("rect_ex").value=rect_ex;
                                document.getElementById("rect_ey").value=rect_ey;
                            });
                        });
                        $(function(){
                          $('#tsuchiya').click(function() //送信ボタンをクリック
                          {
                            if($('#rect_sx').val()== '' || $('#rect_sy').val()== '' || $('#rect_ex').val()== '' || $('#rect_ey').val()== '')
                            {
                              alert('快適度を決定づけた物体を囲んでください!\nThe answer is incomplete.'); //アラート
                              document.getElementById('tsuchiya').disabled = false;
                            }
                            else if( $('input[name="comfortable"]:checked').val() == window.undefined && $('#object_name').val() == "" && $('#factors').val() == "")
                            {
                              alert('快適度・物体の名称・快適度の決定指標を選択してください!\nThe answer is incomplete.'); //アラート
                              document.getElementById('tsuchiya').disabled = false;
                            }
                            else if( $('input[name="comfortable"]:checked').val() != window.undefined && $('#object_name').val() == "" && $('#factors').val() == "")
                            {
                              alert('物体の名称・快適度の決定指標を選択してください!\nThe answer is incomplete.'); //アラート
                              document.getElementById('tsuchiya').disabled = false;
                            }
                            else if( $('input[name="comfortable"]:checked').val() == window.undefined && $('#object_name').val() != "" && $('#factors').val() == "")
                            {
                              alert('快適度・快適度の決定指標を選択してください!\nThe answer is incomplete.'); //アラート
                              document.getElementById('tsuchiya').disabled = false;
                            }
                            else if( $('input[name="comfortable"]:checked').val() == window.undefined && $('#object_name').val() == "" && $('#factors').val() != "")
                            {
                              alert('快適度・物体の名称を選択してください!\nThe answer is incomplete.'); //アラート
                              document.getElementById('tsuchiya').disabled = false;
                            }
                            else if( $('input[name="comfortable"]:checked').val() == window.undefined && $('#object_name').val() != "" && $('#factors').val() != "")
                            {
                              alert('快適度を選択してください!\nThe answer is incomplete.'); //アラート
                              document.getElementById('tsuchiya').disabled = false;
                            }
                            else if($('input[name="comfortable"]:checked').val() != window.undefined && $('#object_name').val() == "" && $('#factors').val() != "")
                            {
                              alert('物体の名称を選択してください!\nThe answer is incomplete.'); //アラート
                              document.getElementById('tsuchiya').disabled = false;
                            }
                            else if( $('#object_name').val() != "" && $('input[name="comfortable"]:checked').val() != window.undefined && $('#factors').val() == "")
                            {
                              alert('快適度の決定指標を選択してください!\nThe answer is incomplete.'); //アラート
                              document.getElementById('tsuchiya').disabled = false;
                            // }
                            //タイの人が面倒くさがりだから確認のアラート消した(2019 9/12)
                            // else if(!confirm('入力情報を送信してよろしいですか?')){

                            //     /* キャンセルの時の処理 */
                            //     document.getElementById('tsuchiya').disabled = false;
                            //     document.getElementById('on').click(); //リンク無効

                            //     return false;
                            }else{
                                $.ajax(
                                {
                                  type: "POST", //POSTで渡す
                                  url: "/insert_data", //POST先
                                  data:
                                  {
                                    "gender":$('input:hidden[name="gender"]').val(),
                                    "age":$('input:hidden[name="age"]').val(),
                                    "nationality":$('input:hidden[name="nationality"]').val(),
                                    "image_type":$('#object_name').val(),
                                    "factors":$('#factors').val(),
                                    "image_name":$('input:hidden[name="image_name"]').val(),
                                    "image_path":$('input:hidden[name="image_path"]').val(),
                                    "comfortable":$('input[name="comfortable"]:checked').val(),
                                    "rect_sx":$('#rect_sx').val(),
                                    "rect_sy":$('#rect_sy').val(),
                                    "rect_ex":$('#rect_ex').val(),
                                    "rect_ey":$('#rect_ey').val(),
                                  },
                                  success: function(data) //通信成功、/insert_dataからの返り値を受け取る
                                  {
                                    if(data==0) //返り値が0かつ快適度・物体の名称が選択済み→成功
                                    {
                                      alert('送信しました!\nSuccessful!');
                                      document.getElementById('off').click(); //リンク有効
                                      document.getElementById('off_finish').click(); //リンク有効
                                      
                                      $('a.finish').showBalloon({ position: "top" });



                                      // window.location.href = "/";
                                      
                                    }
                                    else if(data==1) //返り値が1→失敗
                          　　　　　　{
                                      alert('失敗しました');
                                    }
                                  },
                                  error: function(XMLHttpRequest, textStatus, errorThrown) //通信失敗
                                  {           
                                    alert('Error');
                                    document.getElementById('tsuchiya').disabled = false;

                                    　　console.log("XMLHttpRequest : " + XMLHttpRequest.status);
                                    　　console.log("textStatus     : " + textStatus);
                                    　　console.log("errorThrown    : " + errorThrown.message);
                                  }
                                });
                                return false; //ページが更新されるのを防ぐ
                            }
                          });
                        });
                        </script>

                </div>
        @if($objects -> currentPage() == 15)
                  <br>
                  <div class="parent">
                  <a class="finish" href="/select" title="アンケートにご協力いただきまして誠にありがとうございました!">
                      <button class="btn btn-primary btn-lg btn-block" name="finish" value="value">Finish</button>
                  </a>
                  </div>
                @endif
        @endforeach
        <center>
        <div class="d-flex justify-content-center">
          
                {{ $objects->appends(['object_type'=>$object_type])->links() }}
                {{-- simple-bootstrap-4.blade.phpを編集 --}}
        </div>
        </center>
      </div>

    @else
        <h1>Image not found</h1>
        <a href="/select" class="btn btn-default">Go Back</a>
    @endif

    <button id="on" style="display: none;">無効</button>
    <button id="off" style="display: none;">有効</button>

    <button id="on_finish" style="display: none;">無効</button>
    <button id="off_finish" style="display: none;">有効</button>



    <!-- ここから追加： F5 と Ctrl+R、Command+R によるリロードを抑える -->
    <!-- Windows Safari の F5 の場合は問題の出ない再読み込みを行う -->
    <script type="text/javascript">
      var if_ctrl = 0;
      var if_r = 0;
      function is_ctrl(pressKey){
              if(pressKey==17){ //ctrl
                      return 1;
              } else if (navigator.userAgent.match(/macintosh/i)){
                      if (pressKey == 224 && navigator.userAgent.match(/firefox/i)){
                              return 1;
                      } else if (pressKey == 91 || pressKey == 93){
                              return 1;
                      }
              }
              return 0;
      }
      function disable_reload(e){
              if(navigator.userAgent.match(/msie/i) && window.event){
                      window.event.returnValue=false;
                      window.event.keyCode=0
              } else
              if (navigator.userAgent.match(/macintosh/i) || e.preventDefault){
                      e.preventDefault();
                      e.stopPropagation();
              }
              return false;
      }
      function catchkeydown(e){
              var pressKey;
              if (eval(e)){
                      pressKey=e.keyCode;
              } else {
                      pressKey=event.keyCode;
              }
              if(is_ctrl(pressKey)==1){ //ctrl
                      if_ctrl=1;
                      if(if_r==1){return disable_reload(e);}
              }
              if(pressKey==82){ //r
                      if_r=1;
                      if(if_ctrl==1){return disable_reload(e);}
              }
              if(pressKey==116){ //f5
                      if (navigator.userAgent.match(/safari/i) 
                              && !navigator.userAgent.match(/chrome/i)){
                              window.location="%_myname_%?n=%_n_%&i=%_i_%";
                              return true;
                      } else {
                              return disable_reload(e);
                      }
              }
      }
      function catchkeyup(e){
              var pressKey;
              if (eval(e)){
                      pressKey=e.keyCode;
              } else {
                      pressKey=event.keyCode;
              }
              if(is_ctrl(pressKey)==1){ //ctrl
                      if_ctrl=0;
                      if(if_r==1){return disable_reload(e);}
              }
              if(pressKey==82){ //r
                      if_r=0;
                      if(if_ctrl==1){return disable_reload(e);}
              }
              if(pressKey==116){ //f5
                      if (navigator.userAgent.match(/safari/i) 
                              && !navigator.userAgent.match(/chrome/i)){
                              window.location="%_myname_%?n=%_n_%&i=%_i_%";
                      } else {
                              return disable_reload(e);
                      }
              }
      }
      document.onkeydown = catchkeydown;
      document.onkeyup = catchkeyup;

      history.pushState(null, null, null);
      $(window).on("popstate", function (event) {
          if (!event.originalEvent.state) {
              history.pushState(null, null, null);
              return;
          }
      });
    </script>
    <!-- ここまで追加： F5 と Ctrl+R、Command+R によるリロードを抑える -->

<style>
a.finish{
margin:0 auto;
display:block;
}
</style>

@endsection

