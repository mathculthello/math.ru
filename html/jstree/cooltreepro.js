// Title: COOLjsTreePRO
// URL: http://javascript.cooldev.com/scripts/cooltreepro/
// Version: 2.3
// Last Modify: 05 Feb 2003
// Author: Sergey Nosenko <darknos@cooldev.com>
// Notes: Registration needed to use this script on your web site.
// Copyright (c) 2001-2002 by CoolDev.Com
// Copyright (c) 2001-2002 by Sergey Nosenko
var NTrees=[];
function bw_check(){var is_major=parseInt(navigator.appVersion);this.nver=is_major;this.ver=navigator.appVersion;this.agent=navigator.userAgent;this.dom=document.getElementById?1:0;this.opera=window.opera?1:0;this.ie5=(this.ver.indexOf("MSIE 5")>-1&&this.dom&&!this.opera)?1:0;this.ie6=(this.ver.indexOf("MSIE 6")>-1&&this.dom&&!this.opera)?1:0;this.ie4=(document.all&&!this.dom&&!this.opera)?1:0;this.ie=this.ie4||this.ie5||this.ie6;this.mac=this.agent.indexOf("Mac")>-1;this.ns6=(this.dom&&parseInt(this.ver)>=5)?1:0;this.ie3=(this.ver.indexOf("MSIE")&&(is_major<4));this.hotjava=(this.agent.toLowerCase().indexOf('hotjava')!=-1)?1:0;this.ns4=(document.layers&&!this.dom&&!this.hotjava)?1:0;this.bw=(this.ie6||this.ie5||this.ie4||this.ns4||this.ns6||this.opera);this.ver3=(this.hotjava||this.ie3);this.opera7=((this.agent.toLowerCase().indexOf('opera 7')>-1) || (this.agent.toLowerCase().indexOf('opera/7')>-1));this.operaOld=this.opera&&!this.opera7;return this;};
function pldImg(arg){for(var i in arg){var im=new Image();im.src=arg[i]}}
function COOLjsTreeFmtPRO( fmt, tree ){
	this.init=function( fmt, tree ){
		this.left=fmt[0];this.top=fmt[1];this.showB=fmt[2];this.clB=fmt[3][0];this.exB=fmt[3][1];this.iE=fmt[3][2];this.Bw=fmt[4][0];this.Bh=fmt[4][1];this.Ew=fmt[4][2];this.showF=fmt[5];this.clF=fmt[6][0];this.exF=fmt[6][1];this.iF=fmt[6][2];this.Fw=fmt[7][0];this.Fh=fmt[7][1];this.ident=fmt[8];
		if (!tree.ver3) this.back=new COOLjsTreeBackPRO(this.left, this.top, fmt[9], 'cls'+tree.name+'_back');
		this.nst=fmt[10];this.nstl=fmt[11];this.so=fmt[12];this.pg=fmt[13][0];this.sp=fmt[13][1];this.exp=fmt[14];this.expimg=fmt[15];this.expimgsize=fmt[16];this.cook=fmt[17];this.rel=fmt[18];this.rels=fmt[19];this.resize=fmt[20];this.sel=fmt[21];this.selC=fmt[22];
		this.selClass=fmt[22]?fmt[22][2]:'';this.nnOnMOver=fmt[24];
		if (this.showB)pldImg([this.clB,this.exB,this.iE]);
		if (this.showF)pldImg([this.exF,this.clF,this.iF]);
	};
	this.nstyle=function (lvl){return und(this.nstl[lvl])?this.nst:this.nstl[lvl]};
	this.idn=function(lvl){return und(this.ident[lvl])?this.ident[0]*lvl:this.ident[lvl]};
	this.init(fmt, tree);
}
function COOLjsTreePRO( name, nodes, format ){
	this.name=name;
	this.bw=new bw_check();
	this.ver3=this.bw.ver3;	
	this.ns4=this.bw.ns4;
	this.fmt=new COOLjsTreeFmtPRO(format, this);
	if (und(NTrees)) NTrees=[];
	NTrees[this.name]=this;
	this.Nodes=[];
	this.rootNode=new COOLjsTreeNodePRO(null, "", "", "", null);
	this.rootNode.treeView=this;
	this.selectedNode=null;
	this.maxWidth=0;
	this.maxHeight=0;
    this.ondraw=null;
	this.moveTo=function(x,y){this.fmt.back.top=y;this.fmt.back.left=y;this.fmt.back.moveTo(x,y);this.fmt.top=y;this.fmt.left=x;this.draw();};
	this.nbn=function(nm){for (var i=0;i<this.Nodes.length;i++) if (this.Nodes[i].text == nm) return this.Nodes[i];return null;};this.nodeByName=this.nbn;
	this.nodeByID=function(id){for(var i=0;i<this.Nodes.length;i++) if (this.Nodes[i].nodeID==id) return this.Nodes[i];return null;};
	this.nodeByURL=function(u){for(var i=0;i<this.Nodes.length;i++) if (this.Nodes[i].url==u) return this.Nodes[i];return null;};
	this.addNode=function (node){
		var parentNode=node.parentNode;
		this.Nodes[this.Nodes.length]=node;
		node.index=this.Nodes.length - 1;
		if (parentNode==null) 
			this.rootNode.children[this.rootNode.children.length]=node;
        else
			parentNode.children[parentNode.children.length]=node;
		return node;
	};
	this.rebuildTree=function(){
		var s="";
		assemlbleChildren(this.rootNode);
		this.rootNode.next=null;
		var nodes = this.Nodes;
		for (var i=0; i < nodes.length; i++){
			nodes[i].initImages();
			if (this.ver3 && nodes[i].hasChildren()) nodes[i].expanded=true;
			s +=nodes[i].init();
		}
		if (this.fmt.rel)
			if (this.bw.ns4){
				var bgc=this.fmt.back.color==""? "" : ' bgcolor="'+this.fmt.back.color+'" ';
				s='<ilayer '+bgc+' id="cls'+this.name+'_back" width="'+this.fmt.rels[0]+'" height="'+this.fmt.rels[1]+'">' + s + '</ilayer>';
			}else{
				var bgc=this.fmt.back.color==""? "" : " background-color:"+this.fmt.back.color+";";
				s='<div id="cls'+this.name+'_back" style="position:relative;left:0px;'+bgc+'top:0px;width:'+this.fmt.rels[0]+'px;height:'+this.fmt.rels[1]+'px;">' + s +'</div>';
			}
		document.write(s);
		this.fmt.back.el=this.bw.ns4?document.layers[this.fmt.back.name]:document.all? document.all[this.fmt.back.name]:document.getElementById(this.fmt.back.name);
		if ( !this.ver3 )for (var i=0; i < this.Nodes.length; i++)this.getEl(this.Nodes[i]);
	};
	this.getEl = function(node){
		if (this.ns4) 
			node.el=this.fmt.rel? this.fmt.back.el.layers[node.id()+"d"]: document.layers[node.id()+"d"];
		else 
			node.el=document.all? document.all[node.id()+"d"] : document.getElementById(node.id()+"d");		
	};
	this.getImg = function(node){
		if (this.ns4) {
			if (this.fmt.showF) node.nf=node.el.document.images[node.id()+"nf"];
			if (this.fmt.showB) node.nb=node.el.document.images[node.id()+"nb"];
		} else {
			if (this.fmt.showB) node.nb=node.el.all? node.el.all[node.id()+"nb"] : document.getElementById(node.id()+"nb");		
			if (this.fmt.showF) node.nf=node.el.all? node.el.all[node.id()+"nf"] : document.getElementById(node.id()+"nf");		
		}
	};
	this.draw=function(){
		if ( this.ver3 ) return;
		this.currTop=this.fmt.top;
		this.maxHeight=0; this.maxWidth=0;
		for (var i=0; i < this.rootNode.children.length; i++)
			this.rootNode.children[i].draw(true);
        if (this.fmt.rel && this.fmt.resize || !this.fmt.rel) 
            this.fmt.back.resize(this.maxWidth-this.fmt.left, this.maxHeight - this.fmt.top);
		if (this.ondraw!=null) this.ondraw(this);
	};
    this.updateImages=function ( node ){
		this.getImg(node);
		var srcB=node.expanded? node.ebtn : node.cbtn;
		var srcF=node.expanded? node.eimg : node.cimg;
		if ((node.treeView.fmt.showB || node.treeView.fmt.exp) && node.nb && node.nb.src!=srcB) node.nb.src=srcB;
		if ((node.treeView.fmt.showF || node.treeView.fmt.exp) && node.nf && node.nf.src!=srcF) node.nf.src=srcF;
	};
	this.expandNode=function( index, nd, sel ){
		if ( this.ver3 ) return;
		var node=this.Nodes[index];
		var pNode=node.parentNode ? node.parentNode : null;
		if (sel==true) this.selectNode( index, true );
		if (!und(node) && node.hasChildren()){
			node.expanded=!node.expanded;
			this.updateImages(node);
			if (!node.expanded)
				node.hideChildren();
			else 
				if (this.fmt.so)
					for (var i=0; i < this.Nodes.length; i++){
						this.Nodes[i].show(false);
						if ( this.Nodes[i]!=node && this.Nodes[i].parentNode==pNode) {
							this.Nodes[i].expanded=false;
							this.updateImages(this.Nodes[i]);
						}
					}
            if (!nd) this.draw();
			if (!nd && this.fmt.cook) this.saveState();
		}
	};
	this.selectNode=function( index , force){
		var node=this.Nodes[index];
		if (force || this.selectedNode!=node )
			if ( !und(node) ){
				var os=this.selectedNode;
				this.selectedNode=node;
				if (this.fmt.sel && os!=null) os.setBGColor(this.fmt.selC[0]);
				if (this.fmt.sel) node.setBGColor(this.fmt.selC[1]);

		if(!(this.ns4||und(this.fmt.selClass)||this.fmt.selClass=='')) {
		//if(os)os.chClass(os.oldClass);
			node.chClass(this.fmt.selClass);
		}
				if (this.onSelectNode!=null) this.onSelectNode( os, node );
				this.saveState();
			}
	};
	this.swapClass=function(os, node){
		if(this.ns4||und(this.fmt.selClass)||this.fmt.selClass=='')return;
		if(os)os.chClass(os.oldClass);
		if(node)node.chClass(this.fmt.selClass);
	};
    this.readOne=function( par, arr , tree){
		if (und(arr)) return;
		var i=0;var nid=0;
		if (arr[i].id) {nid=arr[i].id;i++};
		var node=this.addNode(new COOLjsTreeNodePRO(this, par, arr[i], arr[i+1]==null? "": arr[i+1], arr[i+2]==null? "": arr[i+2] ));
		node.nodeID=nid;
		if (!und(arr[i+3]) && !und(arr[i+3]["format"])){
			node.f=arr[i+3]["format"];
			node.expanded=und(node.f.expanded)?false:node.f.expanded;
			i++;
		}
		while (!und(arr[i+3])){
			par=node;
			this.readOne(par, arr[i+3]);
			i++;
		}
	};
	this.readNodes=function (nodes){
		var ind=0;
		var par=null;
		if (und(nodes) || und(nodes[0]) || und(nodes[0][0])) return;
		for (var i=0; i < nodes.length; i++){
			par=null;
			this.readOne(par, nodes[i], this);
		}
	};
	this.collapseAll=function( rd ){
		if ( this.ver3 ) return;
		for (var i=0; i < this.Nodes.length; i++){
			if (this.Nodes[i].parentNode!=this.rootNode) this.Nodes[i].show(false);
			this.Nodes[i].expanded=false;
			this.updateImages(this.Nodes[i]);
		}
		if (this.fmt.cook) this.saveState();
		if (rd) this.draw();
	};
	this.expandAll=function( rd ){
		if ( this.ver3 ) return;
		for (var i=0; i < this.Nodes.length; i++){
			if (this.Nodes[i].hasChildren()){
				this.Nodes[i].expanded=true;
				this.updateImages(this.Nodes[i]);
			}
		}
		if (this.fmt.cook) this.saveState();
		if (rd) this.draw();
	};
	this.init=function(){
		this.readNodes(nodes);
		if ( !this.ver3 && !this.fmt.rel ) this.fmt.back.init();
		this.rebuildTree();
		if (this.fmt.cook) this.restoreState();
		if (!this.fmt.rel) this.draw();
	};
    this.getCookie=function(sName){
		var aCookie=document.cookie.split("; ");
		for (var i=0; i < aCookie.length ; i++){
			var aCrumb=aCookie[i].split("=");
			if (sName==aCrumb[0]) return unescape(aCrumb[1]);
		}
		return null;
	};
	this.saveState=function(){
		var state="";
		for (var i=0; i < this.Nodes.length; i++) state +=this.Nodes[i].expanded ? '1' : '0';
		/* Uncomment this to keep cookies during month
		var d = new Date();
		d.setMonth(d.getMonth()+15);
		document.cookie=this.name+'State='+state+'; path=/'+'; expires='+d.toGMTString();
		*/
		if (this.selectedNode!=null) document.cookie=this.name+'Selected='+this.selectedNode.index;
		document.cookie=this.name+'State='+state+'; path=/';
	};
	this.restoreState=function (){
		var state=this.getCookie(this.name+'State');
		if (state==null) return;
		for (var i=0; i < this.Nodes.length; i++) if (state.charAt(i)=='1' && this.Nodes[i].hasChildren()) this.expandNode(i, true);
		var sel=this.getCookie(this.name+'Selected'); if (sel) this.selectNode(sel,1);
	};

    this.expandBranch=function (index){
        var node;
        this.collapseAll(false);
        for (node = this.Nodes[index]; node != this.rootNode; node = node.parentNode) {
			if (node.hasChildren()) {
			    node.expanded = true;
			    this.updateImages(node);
			}
        }
        this.selectNode(index, 1);
		if (this.fmt.cook) this.saveState();
        this.draw();
    };
}
function COOLjsTreeNodePRO( treeView, parentNode , text, url, target){
	this.index=-1;
	this.treeView=treeView;
	this.parentNode=parentNode;
	this.text=text;
	this.url=url;
	this.target=target;
	this.f=[];
	this.expanded=false;
    this.children=[];
	this.hasChildren=function(){return this.children.length > 0 || (this.f.hasChildren)};
	this.level=function(){var node=this;var i=0;while(node.parentNode!=null){i++;node=node.parentNode;}return i};
	this.initImages=function (){
		if (!this.treeView) return;
		if (this.treeView.fmt.exp){
			var ei=und(this.f.eimages)? this.treeView.fmt.expimg : this.f.eimages;
			var esz=this.treeView.fmt.expimgsize;
			var img=ei[2];
			this.cimg=this.hasChildren() ? ei[0] : img;
			this.eimg=this.hasChildren() ? ei[1] : img;
			var ii=0;
			ii=this.next==null ? 4 : 3;
			this.ebtn=this.hasChildren() ? ei[ii] : ei[ii+3] ;
			this.cbtn=this.hasChildren() ? ei[ii+2] : ei[ii+2+3];
			this.wbtn=esz[0];this.hbtn=esz[1];this.wimg=esz[0];this.himg=esz[1];
		}else{
			this.cimg=this.hasChildren() ? (!und(this.f.folders))?this.f.folders[0]:this.treeView.fmt.clF : (!und(this.f.folders))?this.f.folders[2]:this.treeView.fmt.iF;
			this.eimg=this.hasChildren() ? (!und(this.f.folders))?this.f.folders[1]:this.treeView.fmt.exF : (!und(this.f.folders))?this.f.folders[2]:this.treeView.fmt.iF;
			this.cbtn=this.hasChildren() ? (!und(this.f.buttons))?this.f.buttons[0]:this.treeView.fmt.clB : (!und(this.f.buttons))?this.f.buttons[2]:this.treeView.fmt.iE;
			this.ebtn=this.hasChildren() ? (!und(this.f.buttons))?this.f.buttons[1]:this.treeView.fmt.exB : (!und(this.f.buttons))?this.f.buttons[2]:this.treeView.fmt.iE;
			this.wbtn=this.treeView.fmt.Bw;
			this.hbtn=this.treeView.fmt.Bh;
		}
	};
	this.init=function(){
		return !this.treeView.ver3?this.treeView.ns4?'<layer id="'+this.id()+'d" z-index="'+this.index+10+'" visibility="hidden">'+this.getContent()+'</layer>':
		'<div id="'+this.id()+'d" style="position:absolute;visibility:hidden;width:1px;z-index:'+this.index+10+';">'+this.getContent()+'</div>':
		this.getContent();	
    };
	this.getH=function(){if(!this.h)this.h=this.treeView.ns4 ? this.el.clip.height:this.treeView.bw.dom&&!this.treeView.bw.operaOld? this.el.firstChild.offsetHeight:this.el.offsetHeight;return this.h};
    this.getW=function(){if(!this.w)this.w=this.treeView.ns4 ? this.el.clip.width:this.treeView.bw.dom&&!this.treeView.bw.operaOld? this.el.firstChild.offsetWidth:this.el.offsetWidth;return this.w};
	this.id=function(){return 'nt'+this.treeView.name+this.index;};
    this.getContent=function( ){
		function itemSquare(node){
			var img=node.expanded ? node.eimg : node.cimg;
			return "<td valign=\"middle\" width=\""+node.wbtn+"\"><img id=\""+node.id()+"nf\" name=\""+node.id()+"nf\" src=\"" + img + "\" width="+node.wbtn+" height="+node.hbtn+" border=0></td>\n";
		}
		function buttonSquare(node){
			var img=node.expanded? node.ebtn : node.cbtn;
			var s = '<td valign=\"middle\" width="'+node.wbtn+'">';
			var i = '<img name=\''+node.id()+'nb\' id=\''+node.id()+'nb\' src="' + img + '" width="'+node.wbtn+'" height="'+node.hbtn+'" border=0>';
			var onm = node.treeView.fmt.nnOnMOver?' onmouseout="window.status=\'\';return true" onmouseover="window.status=\''+node.text+'\';return true"':'';
			return node.hasChildren() ? s+'<a onclick="this.blur()"'+onm+' href="javascript:NTrees[\''+node.treeView.name+'\'].expandNode('+node.index+')">'+i+'</a></td>\n' : s+i+'</td>\n';
		}
		function blankSquares(node, ww, ll){
			if (node.treeView.fmt.exp){
				if (ll==0) return "";var i; var ii;var res="";
				var w=node.treeView.fmt.expimgsize[0];
				var h=node.treeView.fmt.expimgsize[1];
				var pnode=node;
				for (i=ll;i>0;i--){
					if (pnode.parentNode!=null) pnode=pnode.parentNode;
					var img=pnode.next==null ? node.treeView.fmt.iE : node.treeView.fmt.expimg[7];
					res="<td width=\""+w+"\"><img src=\"" + img + "\" width="+w+" height="+h+" border=0></td>" + res;
				}
				return res;
			}else{
				var img=node.treeView.fmt.iE;
				return "<td width=\""+ww+"\"><img src=\"" + img + "\" width="+ww+" height=1 border=0></td>\n";
			}
		}
		var s=''; var ll=this.level();
		s +='<table cellpadding='+this.treeView.fmt.pg+' cellspacing='+this.treeView.fmt.sp+' border=0 class="cls'+this.treeView.name+'_back'+ll+'"><tr>';
		var idn=this.treeView.fmt.idn(ll);
		if (idn > 0  || this.treeView.fmt.exp ) s +=blankSquares(this, idn, ll);
		if ( this.treeView.fmt.showB || this.treeView.fmt.exp) s +=this.treeView.fmt.exp ? buttonSquare(this) : (this.hasChildren() ?  buttonSquare(this) : blankSquares(this, this.treeView.fmt.Ew));
		if ( this.treeView.fmt.showF ) s +=itemSquare(this);
		var exp = 'NTrees[\''+this.treeView.name+'\'].expandNode('+this.index+', 0, 1)';
		var u = !this.url?"javascript:"+exp:this.url;
        var onc = this.url?'onclick="'+exp+';this.blur()"': 'onclick="this.blur()"';
		var targ = this.target?' target="'+this.target+'"':'';
		var onm = this.treeView.fmt.nnOnMOver&&this.hasChildren()?' onmouseout="window.status=\'\';return true" onmouseover="window.status=\''+this.text+'\';return true"':'';
		var t = '<a'+onm+' id="'+this.id()+'an" class="'+this.treeView.fmt.nstyle(ll)+'" href="'+u+'" '+onc+targ+'>'+this.text+'</a>';
		s +=this.treeView.ns4?'<td nowrap=\"1\"><ilayer id="'+this.id()+'a">'+t+'</ilayer></td></tr></table>' : '<td nowrap=\"1\"><div id="'+this.id()+'a">'+t+'</div></td></tr></table>';
		return s;
	};
	this.moveTo=function( x, y ){
		if (this.treeView.ns4)
			this.el.moveTo(x,y);
		else {
			this.el.style.left=x;
			this.el.style.top=y;
		}
	};
	this.show=function(sh){
		if (this.visible==sh) return;
		this.visible=sh;
		var vis=this.treeView.ns4 ? (sh ? 'show': 'hide') : (sh ? 'visible': 'hidden');
		if (this.treeView.ns4) this.el.visibility=vis; else this.el.style.visibility=vis;
	};
	this.hideChildren=function(){this.show(false); for (var i=0; i < this.children.length; i++)this.children[i].hideChildren();};
    this.draw=function(){
		var ll=this.treeView.fmt.left;
		var left=this.treeView.fmt.rel && this.treeView.bw.operaOld? this.treeView.fmt.left + this.treeView.operaLeft: this.treeView.fmt.left;
		var top=this.treeView.fmt.rel && this.treeView.bw.operaOld? this.treeView.currTop + this.treeView.operaTop:this.treeView.currTop;
		this.moveTo(left, top);var w = this.getW();this.show(true);if (ll+w > this.treeView.maxWidth) this.treeView.maxWidth=ll+w;
		this.treeView.currTop +=this.getH();
		if (this.treeView.currTop > this.treeView.maxHeight) this.treeView.maxHeight=this.treeView.currTop;
		if (this.expanded && this.hasChildren() ) for (var i=0; i < this.children.length; i++) this.children[i].draw();
	};
	this.setBGColor=function (color){
		var el=this.treeView.bw.ns4 ? this.el.layers[this.id()+'a']:document.all ? document.all[this.id()+'a'] : document.getElementById(this.id()+'a');
		if (this.treeView.bw.ns4)el.bgColor=color; else if (el.style) el.style.backgroundColor=color;
	};
	this.chClass=function(cls){
		var el=document.all? document.all[this.id()+"an"] : document.getElementById(this.id()+"an");
        this.oldClass=el.className;
		this.show(0);
		el.className = cls;
        this.show(1);
	};
	return this;
}
function assemlbleChildren( node ){
	if (node.children.length > 0 ) node.children[node.children.length-1].next=null;
	for (var i=0; i < node.children.length; i++){
		if ( i+1 < node.children.length ) node.children[i].next=node.children[i+1];
		if (node.children[i].children.length > 0) assemlbleChildren(node.children[i]);
	}
	return;
}
function COOLjsTreeBackPRO( aleft, atop, color, name ){
	this.bw=new bw_check();
	this.ver3=this.bw.ver3;	
	this.ns4=this.bw.ns4;
	this.left=aleft;
	this.top=atop;
	this.name=name;
	this.color=color;
	this.resize=function(w,h){
		if (this.ns4)
			this.el.resizeTo(w,h);
		else{
			this.el.style.width=w;
			this.el.style.height=h;
		}
	};
	this.init=function(){
		if (this.ns4) {
			var bgc=this.color==""? "" : ' bgcolor="'+this.color+'" ';
			document.write('<layer '+bgc+' top="'+this.top+'" left="'+this.left+'" id="'+this.name+'" z-index="0"></layer>');
			this.el=document.layers[this.name];
		} else {
			var bgc=this.color==""? "" : " background-color:"+this.color+";";
			document.write('<div id="'+this.name+'" style="'+bgc+'position:absolute;z-index:0;top:'+this.top+'px;left:'+this.left+'px"></div>');
			this.el=document.all? document.all[this.name] : document.getElementById(this.name);	
		}
	};
}
function und( val ){return typeof(val)=='undefined'}
function RedrawAllTrees(){for (var tree in NTrees) NTrees[tree].draw()}
window.oldCTOnLoad=window.onload;
function CTOnLoad(){
	var bw=new bw_check();
	if (bw.ns4 || bw.operaOld){
		window.origWidth=window.innerWidth;
		window.origHeight=window.innerHeight;
	}
	if (bw.operaOld){
		if (!window.operaResizeTimer) resizeHandler();
		for (var tree in NTrees){
			for (var j=0;j<NTrees[tree].Nodes.length;j++){
				if (NTrees[tree].fmt.rel){
					var l=NTrees[tree].fmt.back.el.offsetParent.offsetLeft;
					var t=NTrees[tree].fmt.back.el.offsetParent.offsetTop;
					var par=NTrees[tree].fmt.back.el.offsetParent;
					while (par!=document.body){
						l +=par.offsetLeft;
						t +=par.offsetTop;
						par=par.offsetParent;
					}
					NTrees[tree].operaTop=t;
					NTrees[tree].operaLeft=l;
				}
				if (NTrees[tree].Nodes[j].visible) NTrees[tree].Nodes[j].el.style.visibility='visible';
			}
			NTrees[tree].draw();
		}
	}
	if (typeof(window.oldCTPOnLoad)=='function') window.oldCTPOnLoad();
	if (bw.ns4) window.onresize=resizeHandler;
}
window.onload=new CTOnLoad();
function resizeHandler() {
	if (window.reloading) return;
	var reload=window.innerWidth != window.origWidth || window.innerHeight != window.origHeight;
	window.origWidth=window.innerWidth;window.origHeight=window.innerHeight;
	if (window.operaResizeTimer)clearTimeout(window.operaResizeTimer);
	if (reload) {window.reloading=1;document.location.reload();return};
	if (new bw_check().operaOld) window.operaResizeTimer=setTimeout('resizeHandler()',500);
}
