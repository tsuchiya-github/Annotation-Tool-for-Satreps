@extends('layouts.app')

@section('content')
    <h1>Questionnaire</h1>
    <div class="well-lg" style="margin-bottom: 50px;">
        <div class="panel panel-success">
            <div class="panel-heading"><h4>アンケート項目一覧表</h4>
            </div>
                <div class="panel-body">
                    各項目はそれぞれ15問で構成されています．お好きな項目をお選びください．
                    <hr>
                    <h3>アンケートのやり方</h3>
                    <div class="panel-group" id="Accordion">
	<div class="panel panel-success">
		<div class="panel-heading">
			<h3 class="panel-title">
				<a data-toggle="collapse" data-parent="#Accordion" href="#AccordionCollapse1">
				Step 1．矩形選択をしてください!
				</a>
			</h3>
		</div>
		<div id="AccordionCollapse1" class="panel-collapse collapse">
			<div class="panel-body">
            <li>あなたのQoLに最も影響を与えた物体をマウスで選択してください．切り出した画像が横に表示されます．(Use the mouse to crop only one object that has the greatest or least impact on QoL.)</li>
            <br>
            ※必ず左上を開始点，右下を終了点にしてください(Make sure to crop object from the upper left to the lower right. The cropped image is displayed next to it.)
			<img src="/picture/describe/1.png" style="width: 100%;">
			</div>
		</div>
	</div>
	<div class="panel panel-success">
		<div class="panel-heading">
			<h3 class="panel-title">
				<a data-toggle="collapse" data-parent="#Accordion" href="#AccordionCollapse2">
					Step 2．快適度・物体の名称・快適度の決定指標を選択してください!
				</a>
			</h3>
		</div>
		<div id="AccordionCollapse2" class="panel-collapse collapse">
			<div class="panel-body">
            <li>選択した物体があなたにとってどのくらい快適かを5段階で評価してください．(Evaluate how comfortable the selected object is for you on a five-point scale.)</li>
			① Not at all satisfied <br>
			② Slightly satisfied <br>
			③ Neutral <br>
			④ Very satisfied <br>
			⑤ Extremely satisfied
			<li>選択した矩形の物体の名称を選んでください．(Select the name of the cropped object.)</li>
			<li>どの指標をもとに快適度を決定したか選んでください．(Select which index you used to determine your comfort level.)</li>
			<img src="/picture/describe/7.png" style="width: 100%;">
			</div>
		</div>
	</div>
	<div class="panel panel-success">
		<div class="panel-heading">
			<h3 class="panel-title">
				<a data-toggle="collapse" data-parent="#Accordion" href="#AccordionCollapse3">
                    Step 3．「送信する」ボタンをクリックして送信してください!
				</a>
            </h3>
		</div>
		<div id="AccordionCollapse3" class="panel-collapse collapse">
			<div class="panel-body">
            <li>送信が完了すると「Next」ボタンのリンクが有効になります．</li>
            <img src="/picture/describe/3.png" style="width: 100%;">
            </div>
		</div>
    </div>
    <div class="panel panel-success">
		<div class="panel-heading">
			<h3 class="panel-title">
				<a data-toggle="collapse" data-parent="#Accordion" href="#AccordionCollapse4">
                    Step 4．「Next」ボタンをクリックして次ページへ進んでください!
				</a>
			</h3>
		</div>
		<div id="AccordionCollapse4" class="panel-collapse collapse">
			<div class="panel-body">
            <img src="/picture/describe/5.png" style="width: 100%;">
            </div>
		</div>
    </div>
</div>
					
<li>下記リンク内でのページ更新・ページバックはお止めください．
                </div>
        </div>
        <hr>
    </div>
    
    
    @if(count($images) > 0)
        @foreach($images as $image)
            <div class="well">
            <h3><a href="/questionnaire/{{$image->image_name}}?object_type={{$image->image_name}}">{{$image->ID}}:{{$image->image_name}}</a></h3>
            </div>
            
        @endforeach
        <center>
        {{$images->links()}}
        </center>
    @else
        <p>No posts found</p>
    @endif
@endsection



