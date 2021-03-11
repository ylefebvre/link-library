<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

global $colorarray;

$colorarray = array( "#67b484", "#4c6be0", "#9fbb32", "#4d7ad3", "#62c655", "#ce4050", "#45c37c", "#da4f2e", "#41c8d7", "#de862e", "#55a3d9", "#d5ac31", "#4865a2", "#4b9b2f", "#8a96de", "#beb54c", "#2ba198", "#a94c27", "#5ecead", "#e8866b", "#115e41", "#bd6569", "#4e9953", "#925e2a", "#3a9371", "#dba268", "#25735a", "#97831e", "#3b8554", "#a17d3f", "#296437", "#bdb26f", "#387533", "#97ba6d", "#666020", "#3f7821", "#848a49", "#4d6318", "#75902f", "#597236" );

/************************** Function called to create default settings or to reset them on user request **************************/
function ll_reset_options( $settings = 1, $layout = 'list', $setoptions = 'return' ) {

	if ( $layout == 'list' ) {
		$options['num_columns']       = 1;
		$options['showdescription']   = false;
		$options['shownotes']         = false;
		$options['beforenote']        = '<br />';
		$options['afternote']         = '';
		$options['beforeitem']        = '<li>';
		$options['afteritem']         = '</li>';
		$options['beforedesc']        = '';
		$options['afterdesc']         = '';
		$options['displayastable']    = 'false';
		$options['beforelink']        = '';
		$options['afterlink']         = '';
		$options['showcolumnheaders'] = false;
		$options['beforerss']         = '';
		$options['afterrss']          = '';
		$options['beforedate']        = '';
		$options['afterdate']         = '';
		$options['beforeimage']       = '';
		$options['afterimage']        = '';
		$options['beforeweblink']     = '';
		$options['afterweblink']      = '';
		$options['beforetelephone']   = '';
		$options['aftertelephone']    = '';
		$options['beforeemail']       = '';
		$options['afteremail']        = '';
		$options['beforelinkhits']    = '';
		$options['afterlinkhits']     = '';
		$options['columnheaderoverride'] = '';
	} elseif ( $layout == "table" ) {
		$options['num_columns']       = 3;
		$options['showdescription']   = true;
		$options['shownotes']         = true;
		$options['beforenote']        = '<td>';
		$options['afternote']         = '</td>';
		$options['beforeitem']        = '<tr>';
		$options['afteritem']         = '</tr>';
		$options['beforedesc']        = '<td>';
		$options['afterdesc']         = '</td>';
		$options['displayastable']    = 'true';
		$options['beforelink']        = '<td>';
		$options['afterlink']         = '</td>';
		$options['showcolumnheaders'] = true;
		$options['beforerss']         = '<td>';
		$options['afterrss']          = '</td>';
		$options['beforedate']        = '<td>';
		$options['afterdate']         = '</td>';
		$options['beforeimage']       = '<td>';
		$options['afterimage']        = '</td>';
		$options['beforeweblink']     = '<td>';
		$options['afterweblink']      = '</td>';
		$options['beforetelephone']   = '<td>';
		$options['aftertelephone']    = '</td>';
		$options['beforeemail']       = '<td>';
		$options['afteremail']        = '</td>';
		$options['beforelinkhits']    = '<td>';
		$options['afterlinkhits']     = '</td>';
		$options['columnheaderoverride'] = 'Application,Description,Similar to';
	}

	$options['order']                         = 'name';
	$options['hide_if_empty']                 = true;
	$options['table_width']                   = 100;
	$options['catanchor']                     = true;
	$options['flatlist']                      = 'table';
	$options['categorylist_cpt']              = null;
	$options['excludecategorylist_cpt']       = null;
	$options['showrating']                    = false;
	$options['showupdated']                   = false;
	$options['show_images']                   = false;
	$options['use_html_tags']                 = false;
	$options['show_rss']                      = false;
	$options['nofollow']                      = false;
	$options['catlistwrappers']               = 1;
	$options['beforecatlist1']                = '';
	$options['beforecatlist2']                = '';
	$options['beforecatlist3']                = '';
	$options['divorheader']                   = false;
	$options['catnameoutput']                 = 'linklistcatname';
	$options['show_rss_icon']                 = false;
	$options['linkaddfrequency']              = 0;
	$options['addbeforelink']                 = '';
	$options['addafterlink']                  = '';
	$options['linktarget']                    = '';
	$options['showcategorydescheaders']       = false;
	$options['showcategorydesclinks']         = false;
	$options['settingssetname']               = 'Default';
	$options['showadmineditlinks']            = true;
	$options['showonecatonly']                = false;
	$options['loadingicon']                   = '/icons/Ajax-loader.gif';
	$options['defaultsinglecat_cpt']          = '';
	$options['rsspreview']                    = false;
	$options['rsspreviewcount']               = 3;
	$options['rssfeedinline']                 = false;
	$options['rssfeedinlinecontent']          = false;
	$options['rssfeedinlinecount']            = 1;
	$options['rssfeedinlinedayspublished']    = 90;
	$options['rssfeedinlineskipempty']        = false;
	$options['direction']                     = 'ASC';
	$options['linkdirection']                 = 'ASC';
	$options['linkorder']                     = 'name';
	$options['pagination']                    = false;
	$options['linksperpage']                  = 5;
	$options['hidecategorynames']             = false;
	$options['showinvisible']                 = false;
	$options['showinvisibleadmin']            = false;
	$options['showdate']                      = false;
	$options['catdescpos']                    = 'right';
	$options['catlistdescpos']                = 'right';
	$options['showuserlinks']                 = false;
	$options['addnewlinkmsg']                 = __( 'Add new link', 'link-library' );
	$options['linknamelabel']                 = __( 'Link name', 'link-library' );
	$options['linkaddrlabel']                 = __( 'Link address', 'link-library' );
	$options['linkrsslabel']                  = __( 'Link RSS', 'link-library' );
	$options['linkcatlabel']                  = __( 'Link Category', 'link-library' );
	$options['linkdesclabel']                 = __( 'Link Description', 'link-library' );
	$options['linknoteslabel']                = __( 'Link Notes', 'link-library' );
	$options['addlinkbtnlabel']               = __( 'Add Link', 'link-library' );
	$options['newlinkmsg']                    = __( 'New link submitted.', 'link-library' );
	$options['moderatemsg']                   = __( 'It will appear in the list once moderated. Thank you.', 'link-library' );
	$options['rsspreviewwidth']               = 900;
	$options['rsspreviewheight']              = 700;
	$options['imagepos']                      = 'beforename';
	$options['imageclass']                    = '';
	$options['emailnewlink']                  = false;
	$options['emailsubmitter']                = false;
	$options['showaddlinkrss']                = 'hide';
	$options['showaddlinkdesc']               = 'hide';
	$options['showaddlinkcat']                = 'hide';
	$options['showaddlinknotes']              = 'hide';
	$options['usethumbshotsforimages']        = false;
	$options['uselocalimagesoverthumbshots']  = false;
	$options['addlinkreqlogin']               = false;
	$options['showcatlinkcount']              = false;
	$options['publishrssfeed']                = false;
	$options['numberofrssitems']              = 10;
	$options['rssfeedtitle']                  = __( 'Link Library-Generated RSS Feed', 'link-library' );
	$options['rssfeeddescription']            = __( 'Description of Link Library-Generated Feed', 'link-library' );
	$options['showonecatmode']                = 'AJAX';
	$options['paginationposition']            = 'AFTER';
	$options['addlinkcustomcat']              = 'hide';
	$options['linkcustomcatlabel']            = __( 'User-submitted category', 'link-library' );
	$options['linkcustomcatlistentry']        = __( 'User-submitted category (define below)', 'link-library' );
	$options['searchlabel']                   = 'Search';
	$options['dragndroporder']                = implode( ',', range( 1, 22 ) );
	$options['showname']                      = true;
	$options['cattargetaddress']              = '';
	$options['displayweblink']                = 'false';
	$options['sourceweblink']                 = 'primary';
	$options['showtelephone']                 = 'false';
	$options['sourcetelephone']               = 'primary';
	$options['showemail']                     = 'false';
	$options['showlinkhits']                  = false;
	$options['weblinklabel']                  = '';
	$options['telephonelabel']                = '';
	$options['emaillabel']                    = '';
	$options['showaddlinkreciprocal']         = 'hide';
	$options['linkreciprocallabel']           = __( 'Reciprocal Link', 'link-library' );
	$options['showaddlinksecondurl']          = 'hide';
	$options['linksecondurllabel']            = __( 'Secondary Address', 'link-library' );
	$options['showaddlinktelephone']          = 'hide';
	$options['linktelephonelabel']            = __( 'Telephone', 'link-library' );
	$options['showaddlinkemail']              = 'hide';
	$options['linkemaillabel']                = __( 'E-mail', 'link-library' );
	$options['emailcommand']                  = '';
	$options['sourceimage']                   = 'primary';
	$options['sourcename']                    = 'primary';
	$options['tooltipname']                   = 'notooltip';
	$options['enablerewrite']                 = false;
	$options['rewritepage']                   = '';
	$options['storelinksubmitter']            = false;
	$options['maxlinks']                      = '';
	$options['showcaptcha']                   = false;
	$options['beforelinkrating']              = '';
	$options['afterlinkrating']               = '';
	$options['linksubmitternamelabel']        = __( 'Submitter Name', 'link-library' );
	$options['showlinksubmittername']         = 'hide';
	$options['linksubmitteremaillabel']       = __( 'Submitter E-mail', 'link-library' );
	$options['showaddlinksubmitteremail']     = 'hide';
	$options['linksubmittercommentlabel']     = __( 'Submitter Comment', 'link-library' );
	$options['showlinksubmittercomment']      = 'hide';
	$options['addlinkcatlistoverride']        = '';
	$options['showlargedescription']          = false;
	$options['beforelargedescription']        = '';
	$options['afterlargedescription']         = '';
	$options['showcustomcaptcha']             = 'hide';
	$options['customcaptchaquestion']         = __( 'Is boiling water hot or cold?', 'link-library' );
	$options['customcaptchaanswer']           = __( 'hot', 'link-library' );
	$options['rssfeedaddress']                = '';
	$options['addlinknoaddress']              = false;
	$options['featuredfirst']                 = false;
	$options['showlinksonclick']              = false;
	$options['linklargedesclabel']            = __( 'Large Description', 'link-library' );
	$options['showuserlargedescription']      = 'hide';
	$options['usetextareaforusersubmitnotes'] = false;
	$options['showcatonsearchresults']        = false;
	$options['shownameifnoimage']             = false;
	$options['searchresultsaddress']          = '';
	$options['enable_link_popup']             = false;
	$options['link_popup_text']               = __( '%link_image%<br />Click through to visit %link_name%.', 'link-library' );
	$options['popup_width']                   = 300;
	$options['popup_height']                  = 400;
	$options['nocatonstartup']                = false;
	$options['linktitlecontent']              = 'linkname';
	$options['singlelinkid']                  = '';
	$options['combineresults']                = false;
	$options['showifreciprocalvalid']         = false;
	$options['cat_letter_filter']             = 'no';
	$options['cat_letter_filter_autoselect']  = true;
	$options['cat_letter_filter_showalloption'] = true;
	$options['beforefirstlink']                 = '';
	$options['afterlastlink']                   = '';
	$options['searchfieldtext']                 = __( 'Search...', 'link-library' );
	$options['searchnoresultstext']             = __( 'No links found matching your search criteria', 'link-library' );
	$options['catfilterlabel']                  = __( 'Category Filter', 'link-library' );
	$options['addlinkdefaultcat']               = 'nodefaultcat';
	$options['addlinkakismet']                  = false;
	$options['current_user_links']              = false;
	$options['showsubmittername']               = false;
	$options['beforesubmittername']             = '';
	$options['aftersubmittername']              = '';
	$options['onereciprocaldomain']             = false;
	$options['nooutputempty']                   = false;
	$options['showcatdesc']                     = false;
	$options['beforecatdesc']                   = '';
	$options['aftercatdesc']                    = '';
	$options['emailextracontent']               = '';
	$options['showparentcatname']               = false;
	$options['showparentcatdesc']               = false;
	$options['hidechildcatlinks']               = false;
	$options['childcatdepthlimit']              = 0;
	$options['hidechildcattop']                 = false;
	$options['catlinkspermalinksmode']          = false;
	$options['toppagetext']                     = '';
	$options['showbreadcrumbspermalinks']       = false;
	$options['showlinktags']                    = false;
	$options['beforelinktags']                  = '';
	$options['afterlinktags']                   = '';
	$options['showlinkprice']                   = false;
	$options['beforelinkprice']                 = '';
	$options['afterlinkprice']                  = '';
	$options['linkcurrency']                    = '$';
	$options['linkcurrencyplacement']           = 'before';
	$options['show0asfree']                     = true;
	$options['allowcolumnsorting']              = false;
	$options['extraquerystring']                = '';
	$options['updatedlabel']                    = __( 'New', 'link-library' );
	$options['showupdatedpos']                  = 'before';
	$options['showsearchreset']                 = false;
	$options['weblinktarget']                   = '';
	$options['linktagslabel']                   = __( 'Link Tags', 'link-library' );
	$options['showaddlinktags']                 = 'hide';
	$options['addlinktaglistoverride']          = '';
	$options['linkcustomtaglabel']              = '';
	$options['addlinkcustomtag']                = 'hide';
	$options['linkcustomtaglistentry']          = 'User-submitted tag (define below)';
	$options['showscheduledlinks']              = false;
	$options['maxlinkspercat']                  = '';
	$options['suppressnoreferrer']              = false;
	$options['linkaddrdefvalue']                = 'https://';
	$options['userlinkcatselectionlabel']       = __( 'Select a category', 'link-library' );
	$options['dropdownselectionprompt']         = false;
	$options['dropdownselectionprompttext']     = __( 'Select a category', 'link-library' );
	$options['showcatname']                     = false;
	$options['beforecatname']                   = '';
	$options['aftercatname']                    = '';
	$options['onelinkperdomain']                = '';
	$options['showupdatedtooltip']              = false;
	$options['linkimagelabel']                  = __( 'Link Image (jpg, jpeg, png)', 'link-library' ) ;
	$options['showaddlinkimage']                = 'hide';
	$options['datesource']                      = 'updateddate';
	$options['taglist_cpt']                     = '';
	$options['excludetaglist_cpt']              = '';
	$options['taglinks']                        = 'inactive';
	$options['catlistchildcatdepthlimit']       = '';
	$options['linknametooltip']                 = '';
	$options['linkaddrtooltip']                 = '';
	$options['linkrsstooltip']                  = '';
	$options['linkcattooltip']                  = '';
	$options['linkusercattooltip']              = '';
	$options['linktagtooltip']                  = '';
	$options['linkusertagtooltip']              = '';
	$options['linkdesctooltip']                 = '';
	$options['linknotestooltip']                = '';
	$options['linkimagetooltip']                = '';
	$options['linkreciptooltip']                = '';
	$options['linksecondtooltip']               = '';
	$options['linktelephonetooltip']            = '';
	$options['linkemailtooltip']                = '';
	$options['submitternametooltip']            = '';
	$options['submitteremailtooltip']           = '';
	$options['submittercommenttooltip']         = '';
	$options['largedesctooltip']                = '';
	$options['linkfilelabel']                   = '';
	$options['linkfiletooltip']                 = '';
	$options['showaddlinkfile']                 = 'hide';
	$options['linkfileallowedtypes']            = 'pdf,zip';
	$options['displaycustomurl1']               = 'false';
	$options['displaycustomurl2']               = 'false';
	$options['displaycustomurl3']               = 'false';
	$options['displaycustomurl4']               = 'false';
	$options['displaycustomurl5']               = 'false';
	$options['beforecustomurl1']                = '';
	$options['beforecustomurl2']                = '';
	$options['beforecustomurl3']                = '';
	$options['beforecustomurl4']                = '';
	$options['beforecustomurl5']                = '';
	$options['aftercustomurl1']                 = '';
	$options['aftercustomurl2']                 = '';
	$options['aftercustomurl3']                 = '';
	$options['aftercustomurl4']                 = '';
	$options['aftercustomurl5']                 = '';
	$options['labelcustomurl1']                 = '';
	$options['labelcustomurl2']                 = '';
	$options['labelcustomurl3']                 = '';
	$options['labelcustomurl4']                 = '';
	$options['labelcustomurl5']                 = '';
	$options['customurl1target']                = '';
	$options['customurl2target']                = '';
	$options['customurl3target']                = '';
	$options['customurl4target']                = '';
	$options['customurl5target']                = '';
	$options['searchtextinsearchbox']           = false;
	$options['showuservotes']                   = false;
	$options['beforeuservotes']                 = '';
	$options['afteruservotes']                  = '';
	$options['membersonlylinkvotes']            = false;
	$options['uservotelikelabel']               = 'Like';
	$options['searchfiltercats']                = false;
	$options['displaycustomtext1']               = 'false';
	$options['displaycustomtext2']               = 'false';
	$options['displaycustomtext3']               = 'false';
	$options['displaycustomtext4']               = 'false';
	$options['displaycustomtext5']               = 'false';
	$options['beforecustomtext1']                = '';
	$options['beforecustomtext2']                = '';
	$options['beforecustomtext3']                = '';
	$options['beforecustomtext4']                = '';
	$options['beforecustomtext5']                = '';
	$options['aftercustomtext1']                 = '';
	$options['aftercustomtext2']                 = '';
	$options['aftercustomtext3']                 = '';
	$options['aftercustomtext4']                 = '';
	$options['aftercustomtext5']                 = '';
	$options['displaycustomlist1']               = 'false';
	$options['displaycustomlist2']               = 'false';
	$options['displaycustomlist3']               = 'false';
	$options['displaycustomlist4']               = 'false';
	$options['displaycustomlist5']               = 'false';
	$options['beforecustomlist1']                = '';
	$options['beforecustomlist2']                = '';
	$options['beforecustomlist3']                = '';
	$options['beforecustomlist4']                = '';
	$options['beforecustomlist5']                = '';
	$options['aftercustomlist1']                 = '';
	$options['aftercustomlist2']                 = '';
	$options['aftercustomlist3']                 = '';
	$options['aftercustomlist4']                 = '';
	$options['aftercustomlist5']                 = '';
	$options['lazyloadimages']                   = false;
	$options['emailhidepluginmessage']			 = false;
	$options['suppress_image_if_empty']			 = false;
	$options['suppress_link_date_if_empty']		 = false;
	$options['suppress_link_desc_if_empty']		 = false;
	$options['suppress_link_notes_if_empty']	 = false;
	$options['suppress_rss_icon_if_empty']		 = false;
	$options['suppress_tel_if_empty']			 = false;
	$options['suppress_email_if_empty']			 = false;
	$options['suppress_rating_if_empty']		 = false;
	$options['suppress_large_desc_if_empty']	 = false;
	$options['suppress_submitter_if_empty']		 = false;
	$options['suppress_cat_desc_if_empty']		 = false;
	$options['suppress_link_tags_if_empty']		 = false;
	$options['suppress_link_price_if_empty']	 = false;
	$options['suppress_cat_name_if_empty']		 = false;
	$options['suppress_custom_url_1_if_empty']	 = false;
	$options['suppress_custom_url_2_if_empty']	 = false;
	$options['suppress_custom_url_3_if_empty']	 = false;
	$options['suppress_custom_url_4_if_empty']	 = false;
	$options['suppress_custom_url_5_if_empty']	 = false;
	$options['suppress_custom_text_1_if_empty']	 = false;
	$options['suppress_custom_text_2_if_empty']	 = false;
	$options['suppress_custom_text_3_if_empty']	 = false;
	$options['suppress_custom_text_4_if_empty']	 = false;
	$options['suppress_custom_text_5_if_empty']	 = false;
	$options['suppress_custom_list_1_if_empty']	 = false;
	$options['suppress_custom_list_2_if_empty']	 = false;
	$options['suppress_custom_list_3_if_empty']	 = false;
	$options['suppress_custom_list_4_if_empty']	 = false;
	$options['suppress_custom_list_5_if_empty']	 = false;
	$options['catnameformat']					 = 'currentcatname';
	$options['catnamelink']						 = true;
	$options['categoryseparator']				 = ' | ';
	$options['customqueryarg']					 = '';
	$options['customqueryargvalue']				 = '';
	$options['usersubmissiondragndroporder']	 = '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33';
	$options['showlinkreferencelist']			 = 'hide';
	$options['linkreferencelabel']				 = __( 'Link Reference', 'link-library' );
	$options['linkreferencetooltip']		     = '';
	$options['showcustomurl1']				 	 = 'hide';
	$options['showcustomurl2']				 	 = 'hide';
	$options['showcustomurl3']				 	 = 'hide';
	$options['showcustomurl4']				 	 = 'hide';
	$options['showcustomurl5']				 	 = 'hide';
	$options['customurl1tooltip']				 = '';
	$options['customurl2tooltip']				 = '';
	$options['customurl3tooltip']				 = '';
	$options['customurl4tooltip']				 = '';
	$options['customurl5tooltip']				 = '';
	$options['showcustomtext1']				 	 = 'hide';
	$options['showcustomtext2']				 	 = 'hide';
	$options['showcustomtext3']				 	 = 'hide';
	$options['showcustomtext4']				 	 = 'hide';
	$options['showcustomtext5']				 	 = 'hide';
	$options['customtext1tooltip']				 = '';
	$options['customtext2tooltip']				 = '';
	$options['customtext3tooltip']				 = '';
	$options['customtext4tooltip']				 = '';
	$options['customtext5tooltip']				 = '';
	$options['showcustomlist1']				 	 = 'hide';
	$options['showcustomlist2']				 	 = 'hide';
	$options['showcustomlist3']				 	 = 'hide';
	$options['showcustomlist4']				 	 = 'hide';
	$options['showcustomlist5']				 	 = 'hide';
	$options['customlist1tooltip']				 = '';
	$options['customlist2tooltip']				 = '';
	$options['customlist3tooltip']				 = '';
	$options['customlist4tooltip']				 = '';
	$options['customlist5tooltip']				 = '';	
	$options['stylesheet']						 = '';
	$options['masonry']							 = 'inactive';

	if ( 'return_and_set' == $setoptions ) {
		$settingsname = 'LinkLibraryPP' . $settings;
		update_option( $settingsname, $options );
	}

	return $options;
}

// Function used to set general initial settings or reset them on user request
function ll_reset_gen_settings( $setoptions = 'return' ) {
	$genoptions['numberstylesets']             = 1;
	$genoptions['includescriptcss']            = '';
	$genoptions['debugmode']                   = false;
	$genoptions['schemaversion']               = '5.0';
	$genoptions['pagetitleprefix']             = '';
	$genoptions['pagetitlesuffix']             = '';
	$genoptions['thumbshotscid']               = '';
	$genoptions['emaillinksubmitter']          = false;
	$genoptions['suppressemailfooter']         = false;
	$genoptions['moderatorname']               = '';
	$genoptions['moderatoremail']              = '';
	$genoptions['approvalemailtitle']          = '';
	$genoptions['approvalemailbody']           = '';
	$genoptions['rejectedemailtitle']          = '';
	$genoptions['rejectedemailbody']           = '';
	$genoptions['moderationnotificationtitle'] = '';
	$genoptions['linksubmissionthankyouurl']   = '';
	$genoptions['usefirstpartsubmittername']   = '';
	$genoptions['recipcheckaddress']           = get_bloginfo( 'wpurl' );
	$genoptions['recipcheckdelete403']         = false;
	$genoptions['imagefilepath']               = 'absolute';
	$genoptions['catselectmethod']             = 'multiselectlist';
	$genoptions['hidedonation']                = false;
	$genoptions['updatechannel']               = 'standard';
	$genoptions['extraprotocols']              = '';
	$genoptions['fullstylesheet']              = '';
	$genoptions['thumbnailsize']               = '120x90';
	$genoptions['thumbnailgenerator']          = 'robothumb';
	$genoptions['survey2015']                  = false;
	$genoptions['addlinkakismet']              = false;
	$genoptions['rsscachedelay']               = 43200;
	$genoptions['single_link_layout']          = '[link_content]';
	$genoptions['captchagenerator']             = 'easycaptcha';
	$genoptions['recaptchasitekey']             = '';
	$genoptions['recaptchasecretkey']           = '';
	$genoptions['rolelevel']                    = 'Administrator';
	$genoptions['editlevel']                    = 'Administrator';
	$genoptions['cptslug']                      = 'links';
	$genoptions['publicly_queryable']           = false;
	$genoptions['exclude_from_search']          = false;
	$genoptions['defaultlinktarget']            = '_blank';
	$genoptions['bp_log_activity']              = false;
	$genoptions['bp_link_page_url']             = '';
	$genoptions['bp_link_settings']             = '';
	$genoptions['defaultprotocoladmin']         = 'http';
	$genoptions['shrinkthewebaccesskey']        = '';
	$genoptions['pagepeekersize']               = 'm';
	$genoptions['pagepeekerid']                 = '';
	$genoptions['stwthumbnailsize']             = '120x90';
	$genoptions['deletelocalfile']              = false;
	$genoptions['customurl1active']             = false;
	$genoptions['customurl2active']             = false;
	$genoptions['customurl3active']             = false;
	$genoptions['customurl4active']             = false;
	$genoptions['customurl5active']             = false;
	$genoptions['customurl1label']              = '';
	$genoptions['customurl2label']              = '';
	$genoptions['customurl3label']              = '';
	$genoptions['customurl4label']              = '';
	$genoptions['customurl5label']              = '';
	$genoptions['dismissll67update']            = '';
	$genoptions['customtext1active']             = false;
	$genoptions['customtext2active']             = false;
	$genoptions['customtext3active']             = false;
	$genoptions['customtext4active']             = false;
	$genoptions['customtext5active']             = false;
	$genoptions['customtext1label']              = '';
	$genoptions['customtext2label']              = '';
	$genoptions['customtext3label']              = '';
	$genoptions['customtext4label']              = '';
	$genoptions['customtext5label']              = '';
	$genoptions['customlist1active']             = false;
	$genoptions['customlist2active']             = false;
	$genoptions['customlist3active']             = false;
	$genoptions['customlist4active']             = false;
	$genoptions['customlist5active']             = false;
	$genoptions['customlist1label']              = '';
	$genoptions['customlist2label']              = '';
	$genoptions['customlist3label']              = '';
	$genoptions['customlist4label']              = '';
	$genoptions['customlist5label']              = '';
	$genoptions['customlist1values']             = '';
	$genoptions['customlist2values']             = '';
	$genoptions['customlist3values']             = '';
	$genoptions['customlist4values']             = '';
	$genoptions['customlist5values']             = '';
	$genoptions['customlist1html']               = '';
	$genoptions['customlist2html']               = '';
	$genoptions['customlist3html']               = '';
	$genoptions['customlist4html']               = '';
	$genoptions['customlist5html']               = '';
	$genoptions['global_search_results_layout']  = '[link_description]';
	$genoptions['globalsearchresultslinkurl']	 = true;
	$genoptions['globalsearchresultstitleprefix'] = '';

	if ( 'return_and_set' == $setoptions ) {
		$stylesheetlocation           = plugins_url( 'stylesheettemplate.css', __FILE__ );
		$genoptions['fullstylesheet'] = @file_get_contents( $stylesheetlocation );

		update_option( 'LinkLibraryGeneral', $genoptions );
	}

	return $genoptions;
}
