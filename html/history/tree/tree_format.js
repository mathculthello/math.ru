var TREE_FORMAT = [
// 0. x coordinate
	0,
// 1. y coordinate
	0,
// 2. button images flag: true - show buttons, false - don't
	true,
// 3. button images: collapsed, expanded, blank
	[ "/jstree/img/c.gif", "/jstree/img/e.gif", "/jstree/img/b.gif" ],
// 4. button images size: width, height, and indentation for childless nodes
	[ 16, 16, 0 ],
// 5. folder images flag: true - show buttons, false - don't
	false,
// 6. folder images: closed, opened, document
	[ "/jstree/img/fc.gif", "/jstree/img/fe.gif", "/jstree/img/d.gif" ],
// 7. older images size: width, height
	[ 16, 16 ],
// 8. indentation for each level
	[ 0, 64, 128, 192, 256 ],
// 9. background color for the whole tree ("" - transparent)
	"",
// 10. default CSS class for nodes
	"clsNode",
// 11. CSS classes for each level
	[ ],
// 12. single branch mode flag: true - only one branch can be opened,
//     false - any number of branches
	false,
// 13. item padding and spacing
	[ 0, 0 ],
/************** PRO EXTENSIONS ********************/
// 14. explorer-like mode flag: true - enabled (options #2-#8 will be ignored),
//     false - disabled
	true,
// 15. images for explorer-like mode: folder, opened folder, page, button in opened state, same without bottom line, button in closed state, same without bottom line, vertical line, three-way join, two-way join
	[ "/jstree/img/folder.gif", "/jstree/img/folderopen.gif", "/jstree/img/page.gif", "/jstree/img/minus.gif", "/jstree/img/minusbottom.gif", "/jstree/img/plus.gif", "/jstree/img/plusbottom.gif", "/jstree/img/line.gif", "/jstree/img/join.gif", "/jstree/img/joinbottom.gif" ],
// 16. images' size for explorer-like mode
	[ 19, 16 ],
// 17. state saving feature flag: true - tree state will be stored in cookies,
//     false - will not
	false,
// 18. relative positioning flag: true - tree will be placed in the place of
//     its "init()" call, false - absolute coordinates (options #0 and #1) will be used 
	true,
// 19. initial width and height for relative positioning mode
	[ 400, 300 ],
// 20. resizable background for relative positioning mode
	true,
// 21. selected node highlighting mode flag: true - selected node will be
//     highlighted (as option #22 specifies), false - will not
	true,
// 22. attributes for selected node: background color for unselected nodes,
//     same for selected node, CSS class for selected node
	[ "", "", "clsSelected" ]
];
