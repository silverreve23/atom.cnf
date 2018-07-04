'use babel'

var writeFile = require('write');

var markers = new Object();
var colorConfig = null;
var patternStyle = null;
var lessPath = __dirname + '/../styles/highlighte.less';

var exPackage = {

	config : {
		"colorHighlighte": {
			"description": "Select your color and reload atom",
			"type": "color",
			"default": "#2D2D2D"
		}
	},

	activate(state){

		atom.commands.add('atom-workspace', {
			'highlighte:addColor' : this.addColor,
			'highlighte:removeColor' : this.removeColor
		});

		colorConfig = atom.config.get('highlighte.colorHighlighte');

		this.changeStyle(colorConfig);

		atom.config.observe('highlighte.colorHighlighte', (value) => {
			this.changeStyle(value);
		});

	},

	changeStyle(colorConfig){

		patternStyle = `
			.custom-background-color span{
				background-color : ` + colorConfig.toHexString() + `;
			}

			.custom-background-transparent span{
				background-color : transparent;
			}
		`;

		writeFile(lessPath, patternStyle).then(function(){

			console.log('Color highlighte style changed');

		});

	},

	addColor(){

		let editor = atom.workspace.getActiveTextEditor();
		let range = editor.getSelectedBufferRange();
		let editorId = editor.id;
		let rangeStart = range.start.row;
		let rangeEnd = range.end.row;
		let markerId = null;

		for(rangeStart; rangeStart <= rangeEnd; rangeStart++){

			markerId = editorId + ':' + rangeStart;

			if(markers[markerId] == undefined){

				let marker = editor.markBufferRange({
					start : {
						column : 0,
						row : rangeStart
					},
					end : {
						column : 0,
						row : rangeStart
					},
				});

				let decoration = editor.decorateMarker(
					marker,
					{
						type : 'line',
						class : 'custom-background-color',
						onlyHead : true
					}
				);

				markers[markerId] = marker;

			}

		}

	},

	removeColor(){

		let editor = atom.workspace.getActiveTextEditor();
		let range = editor.getSelectedBufferRange();
		let editorId = editor.id;
		let rangeStart = range.start.row;
		let rangeEnd = range.end.row;
		let markerId = null;

		console.log(markers);

		for(rangeStart; rangeStart <= rangeEnd; rangeStart++){

			markerId = editorId + ':' + rangeStart;

			if(markers[markerId])
				while(!markers[markerId].isDestroyed())
					markers[markerId].destroy();

			delete markers[markerId];

		}

	}

};

export default exPackage;
