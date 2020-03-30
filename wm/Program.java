import java.nio.charset.Charset;
import java.sql.*;
import java.lang.*;
import java.util.HashMap;
import java.util.Map;
import java.util.Arrays;

public class Program
{
	final static String[][] arrVersion={
	{
	"개역한글판(korHRV)",  
	"개역개정판(korNKRV)", 
	"새번역(korNRSV)", 
	"공동번역개정판(korNKCB)", 
	"개역개정 국한문(kchNRKV)", 
	"개역한글판 국한문(kchHRV)", 
	"바른성경(korKTV)", 
	"바른성경국한문(kchKTV)", 
	"가톨릭성경(korCath)", 
	"우리말성경(korDOB)", 
	"쉬운성경(korEASY)", 
	"킹제임스흠정역(korHKJV)", 
	"한글킹제임스(korKKJV)", 
	"현대인의 성경(korKLB)", 
	"현대어성경(korTKV)", 
	"ESV", 
	"GNT", 
	"HCSB", 
	"KJV", 
	"MSG", 
	"ISV", 
	"NASB", 
	"NIV", 
	"NKJV", 
	"NLT", 
	"NRSV", 
	"TNIV"
	},
	{
	"korHRV",
	"korNKRV", 
	"korNRSV", 
	"korNKCB", 
	"kchNRKV", 
	"kchHRV", 
	"korKTV", 
	"kchKTV", 
	"korCath", 
	"korDOB", 
	"korEASY", 
	"korHKJV", 
	"korKKJV", 
	"korKLB", 
	"korTKV", 
	"engESV", 
	"engGNT", 
	"engHCSB", 
	"engKJV", 
	"engMSG", 
	"engISV", 
	"engNASB", 
	"engNIV", 
	"engNKJV", 
	"engNLT", 
	"engNRSV", 
	"engTNIV"
	}
	};

	
	final static String[][] arrTables = {
	{ "0","창세기", "출애굽기", "레위기", "민수기", "신명기",
		"여호수아", "사사기", "룻기", "사무엘상", "사무엘하",
		"열왕기상", "열왕기하", "역대상", "역대하", "에스라",
		"느헤미야", "에스더", "욥기", "시편", "잠언",
		"전도서", "아가", "이사야", "예레미야", "예레미야애가",
		"에스겔", "다니엘", "호세아", "요엘", "아모스",
		"오바댜", "요나", "미가", "나훔", "하박국",
		"스바냐", "학개", "스가랴", "말라기", "마태복음",
		"마가복음", "누가복음", "요한복음", "사도행전", "로마서",
		"고린도전서", "고린도후서", "갈라디아서", "에베소서",
		"빌립보서", "골로새서", "데살로니가전서", "데살로니가후서",
		"디모데전서", "디모데후서", "디도서", "빌레몬서",
		"히브리서", "야고보서", "베드로전서", "베드로후서",
		"요한일서", "요한이서", "요한삼서", "유다서", "요한계시록","새교독문","웨스터민스터 신앙고백서"},
		{ "0","창", "출", "레", "민", "신", "수", "삿", "룻", "삼상", "삼하", "왕상", "왕하",
			"대상", "대하", "스", "느", "에", "욥", "시", "잠", "전", "아", "사",
			"렘", "애", "겔", "단", "호", "욜", "암", "옵", "욘", "미", "나", "합",
			"습", "학", "슥", "말", "마", "막", "눅", "요", "행", "롬", "고전",
			"고후", "갈", "엡", "빌", "골", "살전", "살후", "딤전", "딤후", "딛", "몬",
			"히", "약", "벧전", "벧후", "요일", "요이", "요삼", "유", "계","교","웨"},
		{"0","genesis","exodus","leviticus","numbers","deuteronomy","joshua","judges","ruth","1_samuel","2_samuel","1_kings","2_kings","1_chronicles","2_chronicles","ezra","nehemiah","esther","job","psalms","proverbs","ecclesiastes","song_of_solomon","isaiah","jeremiah","lamentations","ezekiel","daniel","hosea","joel","amos","obadiah","jonah","micah","nahum","habakkuk","zephaniah","haggai","zechariah","malachi","matthew","mark","luke","john","acts","romans","1_corinthians","2_corinthians","galatians","ephesians","philippians","colossians","1_thessalonians","2_thessalonians","1_timothy","2_timothy","titus","philemon","hebrews","james","1_peter","2_peter","1_john","2_john","3_john","jude","revelation" }
	
	};

	

	final static String FIND_PATTERN = "([가-힣]+)\\s*([0-9]+):([0-9]+)-([0-9]+)";
	final static String FIND_PATTERN2 = "[0-9\\.tx\\-]";
	final static String FIND_PATTERN3 = "(\\<[^\\>]+\\>)";
	final static String FIND_PATTERN4 = "[0-9]";	
	
	String strBookIndexName="";
	String strBookIndexFullName="";
	String strBookIndexChapter="";

	String get_where(String str)
	{
		String retVal="1";
		String chapter="";

		chapter = str;

		for (int i = 0; i < arrTables[1].length; i++) {
			if(chapter.equals(arrTables[1][i]))
			{
				retVal=String.valueOf(i);;
				this.strBookIndexFullName=arrTables[0][i];
			}
		}
		return retVal;
	}


	
	String get_version(String[] args)
	{
		String retVal="KORNKRV.sqlite";

		try{

		String key=args[0].substring(0, 2);

		Map<String, String> bibleMap = new HashMap<String, String>();
		/* 현대어 성경 */
		bibleMap.put("kh" ,"KORTKV.sqlite");
		/* 새번역 성경 */
		bibleMap.put("kn" ,"kornrsv.sqlite");
		/* 쉬운 성경 */
		bibleMap.put("ke" ,"koreasy.sqlite");
		/* 개역 한글 국한문 성경 */
		bibleMap.put("ko" ,"korHChV.sqlite");
		/* 킹제임스흠정역 성경 */
		bibleMap.put("kk" ,"KORHKJV.sqlite");
		/* ESV */
		bibleMap.put("esv" ,"ESV");
		/* NIV */
		bibleMap.put("niv" ,"NIV");
		/* KJV */
		bibleMap.put("ek" ,"ENGKJV.sqlite");
		/* NewKJV */
		bibleMap.put("en" ,"ENGNKJV.sqlite");
		/* Hebrew */
		bibleMap.put("hb" ,"bible_hebrew.sqlite");
		/* Hebrew */
		bibleMap.put("gr" ,"bible_greek.sqlite");

			retVal=bibleMap.get(key);

			if(retVal==null){
				retVal="KORNKRV.sqlite";
			}else{
//				args[0]=args[0].replaceAll(key, "");
			}
		}catch(ArrayIndexOutOfBoundsException e){
		/*개역개정*/
		retVal="KORNKRV.sqlite";
		}
		return retVal; 
	}
	


	String get_version_name(String[] args)
	{
		String retVal="개역개정";

		try{

		String key=args[0].substring(0, 2);

		Map<String, String> bibleMap = new HashMap<String, String>();
		/* 현대어 성경 */
		bibleMap.put("kh" ,"현대어");
		/* 새번역 성경 */
		bibleMap.put("kn" ,"새번역");
		/* 쉬운 성경 */
		bibleMap.put("ke" ,"쉬운 성경");
		/* 개역 한글 국한문 성경 */
		bibleMap.put("ko" ,"개역 한글 국한문");
		/* 킹제임스흠정역 성경 */
		bibleMap.put("kk" ,"킹제임스흠정역");
		/* KJV */
		bibleMap.put("ek" ,"KJV");
		/* ESV */
		bibleMap.put("esv" ,"ESV");
		/* NIV */
		bibleMap.put("niv" ,"NIV");
		/* NewKJV */
		bibleMap.put("en" ,"NewKJV");
		/* Hebrew */
		bibleMap.put("hb" ,"Hebrew");

		/* Greek */
		bibleMap.put("gr" ,"Greek");
		
			retVal=bibleMap.get(key);
			if(retVal==null){
				retVal="개역개정";
			}else{
				args[0]=args[0].replaceAll(key, "");
			}
		}catch(ArrayIndexOutOfBoundsException e){
		/*개역개정*/
		retVal="개역개정";
		}
		return retVal; 
	}

	String get_chapter(String[] args)
	{
		String retVal="1";
		try{
		retVal=args[0].replaceAll(FIND_PATTERN, "$2");
		}catch(ArrayIndexOutOfBoundsException e){
		}
		return retVal;
	}
	
	//장:절 검색
	String search_verse(String[] args)
	{
		String retVal="";

		if (args.length == 1) {
			retVal = args[0].trim();
			if (-1 < retVal.indexOf("-")) {
				if (retVal.indexOf(":") == -1) {
					showUsage();// -이 있는데 :이 없다면 포맷 오류이다.
				} else {
					// 창3:4-4 이런식이다. OK
				}
			} else {
				int posColone = retVal.indexOf(":");
				if (-1 < posColone) {
					// 창3:4 이런식이다.
					retVal = retVal + "-" + retVal.substring(posColone + 1);// 창3:4-4
					// 이렇게
					// 바꾼다.
				} else {
					// 창4 이런식이다.
					retVal = args[0] + ":1-999";
				}
			}
		} else if (args.length == 2) {
			if (-1 < args[0].indexOf(":")) {// 창1:3 4
				retVal = args[0] + "-" + args[1];
			} else {// 창 1 인경우, 창 1:1, 창 1:3-4
				if (-1 < args[1].indexOf("-") && -1 < args[1].indexOf(":")) {
					retVal = args[0] + args[1];
				} else if (-1 == args[1].indexOf("-")
						&& -1 < args[1].indexOf(":")) {// 창 1:3
					retVal = args[0] + args[1];

					int posColone = retVal.indexOf(":");
					if (-1 < posColone) {
						// 창3:4 이런식이다.
						retVal = retVal + "-" + retVal.substring(posColone + 1);// 창3:4-4
						// 이렇게
						// 바꾼다.
					} else {
						// 창4 이런식이다.
						retVal = args[0] + ":1-999";
					}
				} else {
					retVal = args[0] + args[1] + ":1-999";
				}
			}
		} else if (args.length == 3) {
			retVal = args[0] + args[1] + "-" + args[2];
		} else {
			showUsage();// 인자가 너무 많아도 오류이다.
		}
		/* 장절 검색 끝*/
		return retVal;
	}


	/* iskeyword
	키워드인지 구분
	*/
	boolean isKeyword(String[] args)
	{
		boolean isKeywordSearch=false;
		String searchKeyWord1="", searchKeyWord2="", searchKeyWord3="", searchKeyWord4="";	
		if(args.length==1)
		{
			searchKeyWord1 = args[0];

			if(searchKeyWord1.replaceAll(FIND_PATTERN4,"").equals(searchKeyWord1)) {
				isKeywordSearch = true;
			}
		}
		else if(args.length==2)
		{
			searchKeyWord1 = args[0];
			searchKeyWord2 = args[1];
			
			if(searchKeyWord1.replaceAll(FIND_PATTERN4,"").equals(searchKeyWord1)) {
				isKeywordSearch = true;
			}
			if(isKeywordSearch == false && searchKeyWord2.replaceAll(FIND_PATTERN4,"").equals(searchKeyWord2)) {
				isKeywordSearch = true;
			}
		}
		else if(args.length==3)
		{
			searchKeyWord1 = args[0];
			searchKeyWord2 = args[1];
			searchKeyWord3 = args[2];
			
			if(searchKeyWord1.replaceAll(FIND_PATTERN4,"").equals(searchKeyWord1)) {
				isKeywordSearch = true;
			}
			if(isKeywordSearch == false && searchKeyWord2.replaceAll(FIND_PATTERN4,"").equals(searchKeyWord2)) {
				isKeywordSearch = true;
			}
			if(isKeywordSearch == false && searchKeyWord3.replaceAll(FIND_PATTERN4,"").equals(searchKeyWord3)) {
				isKeywordSearch = true;
			}
		}
		else if(4 <= args.length)
		{
			searchKeyWord1 = args[0];
			searchKeyWord2 = args[1];
			searchKeyWord3 = args[2];
			searchKeyWord4 = args[3];
			
			if(searchKeyWord1.replaceAll(FIND_PATTERN4,"").equals(searchKeyWord1)) {
				isKeywordSearch = true;
			}
			if(isKeywordSearch == false && searchKeyWord2.replaceAll(FIND_PATTERN4,"").equals(searchKeyWord2)) {
				isKeywordSearch = true;
			}
			if(isKeywordSearch == false && searchKeyWord3.replaceAll(FIND_PATTERN4,"").equals(searchKeyWord3)) {
				isKeywordSearch = true;
			}
			if(isKeywordSearch == false && searchKeyWord4.replaceAll(FIND_PATTERN4,"").equals(searchKeyWord4)) {
				isKeywordSearch = true;
			}
		}
		return isKeywordSearch;
	}

	boolean hasOption(String[] args)
	{
		boolean returnHasOption = false;
		int args_length = args.length;
		int last_args = args_length-1;
		if(args[last_args].indexOf("-l")>-1)
		{
		//	System.out.println("has option");
			returnHasOption = true;
		}
		return returnHasOption;
	}

	public static void main(String[] args) throws Exception
	{
		Connection connection = null;
		Connection connection_kh = null; // 현대어
		Connection connection_kn = null; // 새번역
		Connection connection_ke = null; // 쉬운 성경
		Connection connection_ko = null; // 개역 한글 국한문
		Connection connection_kk = null; // 킹제임스흠정역
		Connection connection_ek = null; // KJV
		Connection connection_niv = null; // NIV		
		Connection connection_esv = null; // ESV		
		Connection connection_en = null; // NewKJV
		Connection connection_vietnam = null; // vietnam

		Connection connection_hb = null; // Hebrew
		Connection connection_gr = null; // Greek
		Connection connection_arabic = null;
		Connection connection_burmese = null;
		Connection connection_chinese_niv_sim = null;
		Connection connection_chinese_niv_tra = null;
		Connection connection_chinese_sim = null;
		Connection connection_chinese_tra = null;
		Connection connection_english_kjv = null;
		Connection connection_english_sev = null;
		Connection connection_finnish = null;
		Connection connection_french = null;
		Connection connection_germand45 = null;
		Connection connection_greek = null;
		Connection connection_hebrew = null;
		Connection connection_hindi = null;
		Connection connection_Indonesia_int = null;
		Connection connection_italian = null;
		Connection connection_japan_niv = null; // japan_niv
		Connection connection_khmer_bsc = null;
		Connection connection_korean_skv = null;
		Connection connection_lao = null;
		Connection connection_malay = null;
		Connection connection_mongolia = null;
		Connection connection_portuguese = null;
		Connection connection_russian = null;
		Connection connection_spanish = null;
		Connection connection_tagalong_tab = null;
		Connection connection_tamil = null;
		Connection connection_thailand = null;
		Connection connection_turkish = null;


		Statement statement = null;
		Statement statement_kh = null; // 현대어
		Statement statement_kn = null; // 새번역
		Statement statement_ke = null; // 쉬운 성경
		Statement statement_ko = null; // 개역 한글 국한문
		Statement statement_kk = null; // 킹제임스흠정역
		Statement statement_ek = null; // KJV
		Statement statement_niv = null; // NIV
		Statement statement_esv = null; // ESV
		Statement statement_en = null; // NewKJV
		Statement statement_vietnam = null; // vietnam
		Statement statement_hb = null; // Hebrew
		Statement statement_gr = null; // Greek
		Statement statement_arabic = null; // arabic
		Statement statement_burmese = null; // burmese
		Statement statement_chinese_niv_sim = null; // chinese_niv_sim
		Statement statement_chinese_niv_tra = null; // chinese_niv_tra
		Statement statement_chinese_sim = null; // chinese_sim
		Statement statement_chinese_tra = null; // chinese_tra
		Statement statement_english_kjv = null; // english_kjv
		Statement statement_english_sev = null; // english_sev
		Statement statement_finnish = null; // finnish
		Statement statement_french = null; // french
		Statement statement_germand45 = null; // germand45
		Statement statement_greek = null; // greek
		Statement statement_hebrew = null; // hebrew
		Statement statement_hindi = null; // hindi
		Statement statement_Indonesia_int = null; // Indonesia_int
		Statement statement_italian = null; // italian
		Statement statement_japan_niv = null; // japan_niv
		Statement statement_khmer_bsc = null; // khmer_bsc
		Statement statement_korean_skv = null; // korean_skv
		Statement statement_lao = null; // lao
		Statement statement_malay = null; // malay
		Statement statement_mongolia = null; // mongolia
		Statement statement_portuguese = null; // portuguese
		Statement statement_russian = null; // russian
		Statement statement_spanish = null; // spanish
		Statement statement_tagalong_tab = null; // tagalong_tab
		Statement statement_tamil = null; // tamil
		Statement statement_thailand = null; // thailand
		Statement statement_turkish = null; // turkish

		Program pg=new Program();
		
		String version=pg.get_version(args);
		String version_name=pg.get_version_name(args);
		boolean hasOption = pg.hasOption(args);

		StringBuilder sb = new StringBuilder();

		if(hasOption)
		{
			args=Arrays.copyOf(args, args.length-1);
		}

		String book="";
		String chapter=pg.get_chapter(args);
		String s = "";
		String searchStr1="",searchStr2="",searchStr3="",searchStr4="";
		boolean is_west=false;		
		
		String tmpA="";

		/* 장절 검색 */
		tmpA=pg.search_verse(args);

		/**
		* 키워드 검색 인지 구절 검색인지 판단, 
		* 기본값은 'false'로 구절 검색이다. 
		*/
		boolean isKeywordSearch = false;
		isKeywordSearch = pg.isKeyword(args);




		String strFileName = "";
		String strBookIndexName = "";
		strBookIndexName = tmpA.replaceAll(FIND_PATTERN, "$1");
		
		strBookIndexName = strBookIndexName.trim();
		strBookIndexName = strBookIndexName.trim();

		searchStr1 = strBookIndexName;
		// tmpA.replaceAll(FIND_PATTERN,"$1");
		book=pg.get_where(searchStr1);
		
		is_west=searchStr1.equals("웨");
		/**/
		if(is_west)
		{
			version="WESTMIN.sqlite";
			version_name="웨스터민스터 신앙고백서";
		}
		searchStr2 = tmpA.replaceAll(FIND_PATTERN, "$2");
		searchStr3 = tmpA.replaceAll(FIND_PATTERN, "$3");
		searchStr4 = tmpA.replaceAll(FIND_PATTERN, "$4");



		try
		{
			/* SQLite JDBC 클래스가 있는지 검사하는 부분입니다. */
			Class.forName("org.sqlite.JDBC");
		}
		catch(ClassNotFoundException e)
		{
			System.out.println("org.sqlite.JDBC를 찾지 못했습니다.");
		}

		/* Program.class와 같은 디렉터리에 있는 test.db를 엽니다. */
		String location=new java.io.File( "." ).getCanonicalPath();

		location=location.replaceAll("\\\\", "/");
//	     connection = DriverManager.getConnection("jdbc:sqlite:"+location+"/KORTKV.db");
	     connection = DriverManager.getConnection("jdbc:sqlite:"+location+"/db/"+version);
	     connection_kh = DriverManager.getConnection("jdbc:sqlite:"+location+"/db/KORTKV.sqlite");      
	     connection_kn = DriverManager.getConnection("jdbc:sqlite:"+location+"/db/kornrsv.sqlite");     
	     connection_ke = DriverManager.getConnection("jdbc:sqlite:"+location+"/db/koreasy.sqlite");     
	     connection_ko = DriverManager.getConnection("jdbc:sqlite:"+location+"/db/korHChV.sqlite");     
	     connection_kk = DriverManager.getConnection("jdbc:sqlite:"+location+"/db/KORHKJV.sqlite");     
	     connection_ek = DriverManager.getConnection("jdbc:sqlite:"+location+"/db/ENGKJV.sqlite");      
	     connection_ek = DriverManager.getConnection("jdbc:sqlite:"+location+"/db/ENGKJV.sqlite");      
	     connection_niv = DriverManager.getConnection("jdbc:sqlite:"+location+"/db/ENGNIV.sqlite");      
		 connection_esv = DriverManager.getConnection("jdbc:sqlite:"+location+"/db/ENGESV.sqlite");      
	     connection_en = DriverManager.getConnection("jdbc:sqlite:"+location+"/db/ENGNKJV.sqlite");     
	     connection_vietnam = DriverManager.getConnection("jdbc:sqlite:"+location+"/db/bible_vietnam.sqlite");     
	     connection_arabic = DriverManager.getConnection("jdbc:sqlite:"+location+"/db/bible_arabic.sqlite");
	     connection_burmese = DriverManager.getConnection("jdbc:sqlite:"+location+"/db/bible_burmese.sqlite");
	     connection_chinese_niv_sim = DriverManager.getConnection("jdbc:sqlite:"+location+"/db/bible_chinese_niv_sim.sqlite");
	     connection_chinese_niv_tra = DriverManager.getConnection("jdbc:sqlite:"+location+"/db/bible_chinese_niv_tra.sqlite");
	     connection_chinese_sim = DriverManager.getConnection("jdbc:sqlite:"+location+"/db/bible_chinese_sim.sqlite");
	     connection_chinese_tra = DriverManager.getConnection("jdbc:sqlite:"+location+"/db/bible_chinese_tra.sqlite");
	     connection_english_kjv = DriverManager.getConnection("jdbc:sqlite:"+location+"/db/bible_english_kjv.sqlite");
	     connection_english_sev = DriverManager.getConnection("jdbc:sqlite:"+location+"/db/bible_english_sev.sqlite");
	     connection_finnish = DriverManager.getConnection("jdbc:sqlite:"+location+"/db/bible_finnish.sqlite");
	     connection_french = DriverManager.getConnection("jdbc:sqlite:"+location+"/db/bible_french.sqlite");
	     connection_germand45 = DriverManager.getConnection("jdbc:sqlite:"+location+"/db/bible_germand45.sqlite");
	     connection_hindi = DriverManager.getConnection("jdbc:sqlite:"+location+"/db/bible_hindi.sqlite");
	     connection_Indonesia_int = DriverManager.getConnection("jdbc:sqlite:"+location+"/db/bible_Indonesia_int.sqlite");
	     connection_italian = DriverManager.getConnection("jdbc:sqlite:"+location+"/db/bible_italian.sqlite");
	     connection_japan_niv = DriverManager.getConnection("jdbc:sqlite:"+location+"/db/bible_japan_niv.sqlite");
//	     connection_khmer_bsc = DriverManager.getConnection("jdbc:sqlite:"+location+"/db/bible_khmer_bsc.sqlite");
	     connection_korean_skv = DriverManager.getConnection("jdbc:sqlite:"+location+"/db/bible_korean_skv.sqlite");
	     connection_lao = DriverManager.getConnection("jdbc:sqlite:"+location+"/db/bible_lao.sqlite");
	     connection_malay = DriverManager.getConnection("jdbc:sqlite:"+location+"/db/bible_malay.sqlite");
	     connection_mongolia = DriverManager.getConnection("jdbc:sqlite:"+location+"/db/bible_mongolia.sqlite");
	     connection_portuguese = DriverManager.getConnection("jdbc:sqlite:"+location+"/db/bible_portuguese.sqlite");
	     connection_russian = DriverManager.getConnection("jdbc:sqlite:"+location+"/db/bible_russian.sqlite");
	     connection_spanish = DriverManager.getConnection("jdbc:sqlite:"+location+"/db/bible_spanish.sqlite");
	     connection_tagalong_tab = DriverManager.getConnection("jdbc:sqlite:"+location+"/db/bible_tagalong_tab.sqlite");
//	     connection_tamil = DriverManager.getConnection("jdbc:sqlite:"+location+"/db/bible_tamil.sqlite");
	     connection_thailand = DriverManager.getConnection("jdbc:sqlite:"+location+"/db/bible_thailand.sqlite");
	     connection_turkish = DriverManager.getConnection("jdbc:sqlite:"+location+"/db/bible_turkish.sqlite");
	     connection_hb = DriverManager.getConnection("jdbc:sqlite:"+location+"/db/bible_hebrew.sqlite");
	     connection_gr = DriverManager.getConnection("jdbc:sqlite:"+location+"/db/bible_greek.sqlite"); 
	     connection_greek = DriverManager.getConnection("jdbc:sqlite:"+location+"/db/bible_greek.sqlite"); 
	     connection_hebrew = DriverManager.getConnection("jdbc:sqlite:"+location+"/db/bible_hebrew.sqlite"); 
		
		/* 연결 성공했을 때, connection으로부터 statement 인스턴스를 얻습니다. 여기서 SQL 구문을 수행합니다. */
		statement = connection.createStatement();
		statement_kh = connection_kh.createStatement();
		statement_kn = connection_kn.createStatement();
		statement_ke = connection_ke.createStatement();
		statement_ko = connection_ko.createStatement();
		statement_kk = connection_kk.createStatement();
		statement_ek = connection_ek.createStatement();
		statement_niv = connection_niv.createStatement();
		statement_esv = connection_esv.createStatement();
		statement_vietnam = connection_vietnam.createStatement();
		statement_arabic = connection_arabic.createStatement();
		statement_burmese = connection_burmese.createStatement();
		statement_chinese_niv_sim = connection_chinese_niv_sim.createStatement();
		statement_chinese_niv_tra = connection_chinese_niv_tra.createStatement();
		statement_chinese_sim = connection_chinese_sim.createStatement();
		statement_chinese_tra = connection_chinese_tra.createStatement();
		statement_english_kjv = connection_english_kjv.createStatement();
		statement_english_sev = connection_english_sev.createStatement();
		statement_finnish = connection_finnish.createStatement();
		statement_french = connection_french.createStatement();
		statement_germand45 = connection_germand45.createStatement();
		statement_greek = connection_greek.createStatement();
		statement_hebrew = connection_hebrew.createStatement();
		statement_hindi = connection_hindi.createStatement();
		statement_Indonesia_int = connection_Indonesia_int.createStatement();
		statement_italian = connection_italian.createStatement();
		statement_japan_niv = connection_japan_niv.createStatement();
//		statement_khmer_bsc = connection_khmer_bsc.createStatement();
		statement_korean_skv = connection_korean_skv.createStatement();
		statement_lao = connection_lao.createStatement();
		statement_malay = connection_malay.createStatement();
		statement_mongolia = connection_mongolia.createStatement();
		statement_portuguese = connection_portuguese.createStatement();
		statement_russian = connection_russian.createStatement();
		statement_spanish = connection_spanish.createStatement();
		statement_tagalong_tab = connection_tagalong_tab.createStatement();
//		statement_tamil = connection_tamil.createStatement();
		statement_thailand = connection_thailand.createStatement();
		statement_turkish = connection_turkish.createStatement();

		statement_en = connection_en.createStatement();
		statement_hb = connection_hb.createStatement();
		statement_gr = connection_gr.createStatement();

		/* 아래는 SQL 예시입니다. */
		/* Table1이라는 테이블 안에 field1(text형), field2(integer형)라는 이름의 필드가 있다고 가정합니다. */
		//System.out.println("select * from Bible where book="+book+" and  chapter="+chapter+";");
		//ResultSet rs = statement.executeQuery("select * from Bible where book="+book+" and  chapter="+chapter+" and ;");
		String result="";
		String sql="";
		String sql_hb="";
		String sql_gr="";
		String sql_vietnam="";

		String sql_arabic="";
		String sql_burmese="";
		String sql_chinese_niv_sim="";
		String sql_chinese_niv_tra="";
		String sql_chinese_sim="";
		String sql_chinese_tra="";
		String sql_english_kjv="";
		String sql_english_sev="";
		String sql_finnish="";
		String sql_french="";
		String sql_germand45="";
		String sql_greek="";
		String sql_hebrew="";
		String sql_hindi="";
		String sql_Indonesia_int="";
		String sql_italian="";
		String sql_japan_niv="";
		String sql_khmer_bsc="";
		String sql_korean_skv="";
		String sql_lao="";
		String sql_malay="";
		String sql_mongolia="";
		String sql_portuguese="";
		String sql_russian="";
		String sql_spanish="";
		String sql_tagalong_tab="";
		String sql_tamil="";
		String sql_thailand="";
		String sql_turkish="";

		
		
		/* 검색어 검색*/
		if(isKeywordSearch){
			String searchstr="";
			int i=0;
			for(i=0;i<args.length;i++){
			searchstr+=" "+args[i].trim();
			}
			searchstr=searchstr.trim();
			sql="select *,replace(content,'"+searchstr+"','<b>"+searchstr+"</b>') content2 from bible where content like '%"+searchstr+"%';";
			ResultSet rs = statement.executeQuery(sql);


			i=0;
			while(rs.next())
			{
				
			int  ibook = rs.getInt("book");
			
			String  chapters = rs.getString("chapter");
			String  verse = rs.getString("verse");
			String  content2 = rs.getString("content2");

			System.out.print("[ "+version_name+" ]");
			System.out.print(arrTables[1][ibook]+" ");
	         System.out.print(chapters+":"+verse+" ");
	         System.out.print(content2);
	         System.out.println();
			 i++;
			}
			System.out.println("총 검색 결과 "+i+"개가 검색 되었습니다.");
		return;
		}


		/* 장절 검색*/
		if(searchStr4.equals("999")){
			if(version_name.equals("Hebrew"))
			{

			sql="select c1content as content,c6verse_no as verse from bible_hebrew where c4book_no='"+book+"' and c5chapter_no='"+searchStr2+"' order by c6verse_no desc limit 1;";
			}else if(version_name.equals("Greek")){
			sql="select c1content as content,c6verse_no as verse from bible_greek where c4book_no='"+book+"' and c5chapter_no='"+searchStr2+"' order by c6verse_no desc limit 1;";
			}else{
			sql="select verse from bible where book='"+book+"' and chapter='"+searchStr2+"' order by verse desc limit 1;";
			}
			ResultSet rsv=statement.executeQuery(sql);
			while(rsv.next())
			{
				 searchStr4=rsv.getString("verse");
			}
			/* resultSet 닫기 */
			rsv.close();
		    result=pg.strBookIndexFullName+" "+searchStr2+"장 "+searchStr3+"~"+searchStr4+"절 ["+version_name+"]";	
		}else if(searchStr3.equals(searchStr4)){
			/* 1절 검색 */
			result=pg.strBookIndexFullName+" "+searchStr2+"장 "+searchStr3+"절 ["+version_name+"]";
		}else{
			result=pg.strBookIndexFullName+" "+searchStr2+"장 "+searchStr3+"~"+searchStr4+"절 ["+version_name+"]";
		}



		if(is_west)
		{
			sql="select * from westminster_confession where 1=1 ";
			sql+=" and wm_chapter="+searchStr2;
			sql+=" and wm_clause="+searchStr3;
			sql+=";";

			ResultSet rs = statement.executeQuery(sql);
			/* 결과를 첫 행부터 끝 행까지 반복하며 출력합니다. */
			System.out.println(result);
			while(rs.next())
			{

				String  wm_subject = rs.getString("wm_subject");
				String  content = rs.getString("wm_content");

				 System.out.println("제 "+searchStr2+"장 "+searchStr3+"항");
				 System.out.println(wm_subject);
				 System.out.print(content);
				 System.out.println();
				
			}
			/* resultSet 닫기 */
			rs.close();
			/* DB와의 연결 닫기 */
			connection.close();

		}

		if(!is_west)
		{

				sql_hb="select c1content as content,";
				sql_hb+="c5chapter_no as chapter,";
				sql_hb+="c6verse_no as verse ";
				sql_hb+="from bible_hebrew ";
				sql_hb+="where c4book_no='"+book+"' ";
				sql_hb+="and c5chapter_no='"+searchStr2+"' ";
				sql_hb+=" and c6verse_no>='"+searchStr3;
				sql_hb+="' and c6verse_no<='"+searchStr4+"';";

				sql_gr="select c1content as content,";
				sql_gr+="c5chapter_no as chapter,";
				sql_gr+="c6verse_no as verse ";
				sql_gr+="from bible_greek ";
				sql_gr+="where c4book_no='"+book+"' ";
				sql_gr+="and c5chapter_no='"+searchStr2+"' ";
				sql_gr+=" and c6verse_no>='"+searchStr3;
				sql_gr+="' and c6verse_no<='"+searchStr4+"';";

				sql_japan_niv="select c1content as content,";
				sql_japan_niv+="c5chapter_no as chapter,";
				sql_japan_niv+="c6verse_no as verse ";
				sql_japan_niv+="from bible_japan_niv ";
				sql_japan_niv+="where c4book_no='"+book+"' ";
				sql_japan_niv+="and c5chapter_no='"+searchStr2+"' ";
				sql_japan_niv+=" and c6verse_no>='"+searchStr3;
				sql_japan_niv+="' and c6verse_no<='"+searchStr4+"';";

				sql_vietnam="select c1content as content,";
				sql_vietnam+="c5chapter_no as chapter,";
				sql_vietnam+="c6verse_no as verse ";
				sql_vietnam+="from bible_vietnam ";
				sql_vietnam+="where c4book_no='"+book+"' ";
				sql_vietnam+="and c5chapter_no='"+searchStr2+"' ";
				sql_vietnam+=" and c6verse_no>='"+searchStr3;
				sql_vietnam+="' and c6verse_no<='"+searchStr4+"';";

				sql_vietnam="select c1content as content,";
				sql_vietnam+="c5chapter_no as chapter,";
				sql_vietnam+="c6verse_no as verse ";
				sql_vietnam+="from bible_vietnam ";
				sql_vietnam+="where c4book_no='"+book+"' ";
				sql_vietnam+="and c5chapter_no='"+searchStr2+"' ";
				sql_vietnam+=" and c6verse_no>='"+searchStr3;
				sql_vietnam+="' and c6verse_no<='"+searchStr4+"';";

				sql_arabic="select c1content as content,";
				sql_arabic+="c5chapter_no as chapter,";
				sql_arabic+="c6verse_no as verse ";
				sql_arabic+="from bible_arabic ";
				sql_arabic+="where c4book_no='"+book+"' ";
				sql_arabic+="and c5chapter_no='"+searchStr2+"' ";
				sql_arabic+=" and c6verse_no>='"+searchStr3;
				sql_arabic+="' and c6verse_no<='"+searchStr4+"';";


				sql_burmese="select c1content as content,";
				sql_burmese+="c5chapter_no as chapter,";
				sql_burmese+="c6verse_no as verse ";
				sql_burmese+="from bible_burmese ";
				sql_burmese+="where c4book_no='"+book+"' ";
				sql_burmese+="and c5chapter_no='"+searchStr2+"' ";
				sql_burmese+=" and c6verse_no>='"+searchStr3;
				sql_burmese+="' and c6verse_no<='"+searchStr4+"';";


				sql_chinese_niv_sim="select c1content as content,";
				sql_chinese_niv_sim+="c5chapter_no as chapter,";
				sql_chinese_niv_sim+="c6verse_no as verse ";
				sql_chinese_niv_sim+="from bible_chinese_niv_sim ";
				sql_chinese_niv_sim+="where c4book_no='"+book+"' ";
				sql_chinese_niv_sim+="and c5chapter_no='"+searchStr2+"' ";
				sql_chinese_niv_sim+=" and c6verse_no>='"+searchStr3;
				sql_chinese_niv_sim+="' and c6verse_no<='"+searchStr4+"';";


				sql_chinese_niv_tra="select c1content as content,";
				sql_chinese_niv_tra+="c5chapter_no as chapter,";
				sql_chinese_niv_tra+="c6verse_no as verse ";
				sql_chinese_niv_tra+="from bible_chinese_niv_tra ";
				sql_chinese_niv_tra+="where c4book_no='"+book+"' ";
				sql_chinese_niv_tra+="and c5chapter_no='"+searchStr2+"' ";
				sql_chinese_niv_tra+=" and c6verse_no>='"+searchStr3;
				sql_chinese_niv_tra+="' and c6verse_no<='"+searchStr4+"';";


				sql_chinese_sim="select c1content as content,";
				sql_chinese_sim+="c5chapter_no as chapter,";
				sql_chinese_sim+="c6verse_no as verse ";
				sql_chinese_sim+="from bible_chinese_sim ";
				sql_chinese_sim+="where c4book_no='"+book+"' ";
				sql_chinese_sim+="and c5chapter_no='"+searchStr2+"' ";
				sql_chinese_sim+=" and c6verse_no>='"+searchStr3;
				sql_chinese_sim+="' and c6verse_no<='"+searchStr4+"';";


				sql_chinese_tra="select c1content as content,";
				sql_chinese_tra+="c5chapter_no as chapter,";
				sql_chinese_tra+="c6verse_no as verse ";
				sql_chinese_tra+="from bible_chinese_tra ";
				sql_chinese_tra+="where c4book_no='"+book+"' ";
				sql_chinese_tra+="and c5chapter_no='"+searchStr2+"' ";
				sql_chinese_tra+=" and c6verse_no>='"+searchStr3;
				sql_chinese_tra+="' and c6verse_no<='"+searchStr4+"';";


				sql_english_kjv="select c1content as content,";
				sql_english_kjv+="c5chapter_no as chapter,";
				sql_english_kjv+="c6verse_no as verse ";
				sql_english_kjv+="from bible_english_kjv ";
				sql_english_kjv+="where c4book_no='"+book+"' ";
				sql_english_kjv+="and c5chapter_no='"+searchStr2+"' ";
				sql_english_kjv+=" and c6verse_no>='"+searchStr3;
				sql_english_kjv+="' and c6verse_no<='"+searchStr4+"';";


				sql_english_sev="select c1content as content,";
				sql_english_sev+="c5chapter_no as chapter,";
				sql_english_sev+="c6verse_no as verse ";
				sql_english_sev+="from bible_english_sev ";
				sql_english_sev+="where c4book_no='"+book+"' ";
				sql_english_sev+="and c5chapter_no='"+searchStr2+"' ";
				sql_english_sev+=" and c6verse_no>='"+searchStr3;
				sql_english_sev+="' and c6verse_no<='"+searchStr4+"';";


				sql_finnish="select c1content as content,";
				sql_finnish+="c5chapter_no as chapter,";
				sql_finnish+="c6verse_no as verse ";
				sql_finnish+="from bible_finnish ";
				sql_finnish+="where c4book_no='"+book+"' ";
				sql_finnish+="and c5chapter_no='"+searchStr2+"' ";
				sql_finnish+=" and c6verse_no>='"+searchStr3;
				sql_finnish+="' and c6verse_no<='"+searchStr4+"';";


				sql_french="select c1content as content,";
				sql_french+="c5chapter_no as chapter,";
				sql_french+="c6verse_no as verse ";
				sql_french+="from bible_french ";
				sql_french+="where c4book_no='"+book+"' ";
				sql_french+="and c5chapter_no='"+searchStr2+"' ";
				sql_french+=" and c6verse_no>='"+searchStr3;
				sql_french+="' and c6verse_no<='"+searchStr4+"';";


				sql_germand45="select c1content as content,";
				sql_germand45+="c5chapter_no as chapter,";
				sql_germand45+="c6verse_no as verse ";
				sql_germand45+="from bible_germand45 ";
				sql_germand45+="where c4book_no='"+book+"' ";
				sql_germand45+="and c5chapter_no='"+searchStr2+"' ";
				sql_germand45+=" and c6verse_no>='"+searchStr3;
				sql_germand45+="' and c6verse_no<='"+searchStr4+"';";


				sql_greek="select c1content as content,";
				sql_greek+="c4book_no as book_no,";
				sql_greek+="c5chapter_no as chapter,";
				sql_greek+="c6verse_no as verse ";
				sql_greek+="from bible_greek ";
				sql_greek+="where c4book_no='"+book+"' ";
				sql_greek+="and c5chapter_no='"+searchStr2+"' ";
				sql_greek+=" and c6verse_no>='"+searchStr3;
				sql_greek+="' and c6verse_no<='"+searchStr4+"';";


				sql_hebrew="select c1content as content,";
				sql_hebrew+="c4book_no as book_no,";
				sql_hebrew+="c5chapter_no as chapter,";
				sql_hebrew+="c6verse_no as verse ";
				sql_hebrew+="from bible_hebrew ";
				sql_hebrew+="where c4book_no='"+book+"' ";
				sql_hebrew+="and c5chapter_no='"+searchStr2+"' ";
				sql_hebrew+=" and c6verse_no>='"+searchStr3;
				sql_hebrew+="' and c6verse_no<='"+searchStr4+"';";


				sql_hindi="select c1content as content,";
				sql_hindi+="c5chapter_no as chapter,";
				sql_hindi+="c6verse_no as verse ";
				sql_hindi+="from bible_hindi ";
				sql_hindi+="where c4book_no='"+book+"' ";
				sql_hindi+="and c5chapter_no='"+searchStr2+"' ";
				sql_hindi+=" and c6verse_no>='"+searchStr3;
				sql_hindi+="' and c6verse_no<='"+searchStr4+"';";


				sql_Indonesia_int="select c1content as content,";
				sql_Indonesia_int+="c5chapter_no as chapter,";
				sql_Indonesia_int+="c6verse_no as verse ";
				sql_Indonesia_int+="from bible_Indonesia_int ";
				sql_Indonesia_int+="where c4book_no='"+book+"' ";
				sql_Indonesia_int+="and c5chapter_no='"+searchStr2+"' ";
				sql_Indonesia_int+=" and c6verse_no>='"+searchStr3;
				sql_Indonesia_int+="' and c6verse_no<='"+searchStr4+"';";


				sql_italian="select c1content as content,";
				sql_italian+="c5chapter_no as chapter,";
				sql_italian+="c6verse_no as verse ";
				sql_italian+="from bible_italian ";
				sql_italian+="where c4book_no='"+book+"' ";
				sql_italian+="and c5chapter_no='"+searchStr2+"' ";
				sql_italian+=" and c6verse_no>='"+searchStr3;
				sql_italian+="' and c6verse_no<='"+searchStr4+"';";


				sql_japan_niv="select c1content as content,";
				sql_japan_niv+="c5chapter_no as chapter,";
				sql_japan_niv+="c6verse_no as verse ";
				sql_japan_niv+="from bible_japan_niv ";
				sql_japan_niv+="where c4book_no='"+book+"' ";
				sql_japan_niv+="and c5chapter_no='"+searchStr2+"' ";
				sql_japan_niv+=" and c6verse_no>='"+searchStr3;
				sql_japan_niv+="' and c6verse_no<='"+searchStr4+"';";


				sql_khmer_bsc="select c1content as content,";
				sql_khmer_bsc+="c5chapter_no as chapter,";
				sql_khmer_bsc+="c6verse_no as verse ";
				sql_khmer_bsc+="from bible_khmer_bsc ";
				sql_khmer_bsc+="where c4book_no='"+book+"' ";
				sql_khmer_bsc+="and c5chapter_no='"+searchStr2+"' ";
				sql_khmer_bsc+=" and c6verse_no>='"+searchStr3;
				sql_khmer_bsc+="' and c6verse_no<='"+searchStr4+"';";


				sql_korean_skv="select c1content as content,";
				sql_korean_skv+="c5chapter_no as chapter,";
				sql_korean_skv+="c6verse_no as verse ";
				sql_korean_skv+="from bible_korean_skv ";
				sql_korean_skv+="where c4book_no='"+book+"' ";
				sql_korean_skv+="and c5chapter_no='"+searchStr2+"' ";
				sql_korean_skv+=" and c6verse_no>='"+searchStr3;
				sql_korean_skv+="' and c6verse_no<='"+searchStr4+"';";


				sql_lao="select c1content as content,";
				sql_lao+="c5chapter_no as chapter,";
				sql_lao+="c6verse_no as verse ";
				sql_lao+="from bible_lao ";
				sql_lao+="where c4book_no='"+book+"' ";
				sql_lao+="and c5chapter_no='"+searchStr2+"' ";
				sql_lao+=" and c6verse_no>='"+searchStr3;
				sql_lao+="' and c6verse_no<='"+searchStr4+"';";


				sql_malay="select c1content as content,";
				sql_malay+="c5chapter_no as chapter,";
				sql_malay+="c6verse_no as verse ";
				sql_malay+="from bible_malay ";
				sql_malay+="where c4book_no='"+book+"' ";
				sql_malay+="and c5chapter_no='"+searchStr2+"' ";
				sql_malay+=" and c6verse_no>='"+searchStr3;
				sql_malay+="' and c6verse_no<='"+searchStr4+"';";


				sql_mongolia="select c1content as content,";
				sql_mongolia+="c5chapter_no as chapter,";
				sql_mongolia+="c6verse_no as verse ";
				sql_mongolia+="from bible_mongolia ";
				sql_mongolia+="where c4book_no='"+book+"' ";
				sql_mongolia+="and c5chapter_no='"+searchStr2+"' ";
				sql_mongolia+=" and c6verse_no>='"+searchStr3;
				sql_mongolia+="' and c6verse_no<='"+searchStr4+"';";


				sql_portuguese="select c1content as content,";
				sql_portuguese+="c5chapter_no as chapter,";
				sql_portuguese+="c6verse_no as verse ";
				sql_portuguese+="from bible_portuguese ";
				sql_portuguese+="where c4book_no='"+book+"' ";
				sql_portuguese+="and c5chapter_no='"+searchStr2+"' ";
				sql_portuguese+=" and c6verse_no>='"+searchStr3;
				sql_portuguese+="' and c6verse_no<='"+searchStr4+"';";


				sql_russian="select c1content as content,";
				sql_russian+="c5chapter_no as chapter,";
				sql_russian+="c6verse_no as verse ";
				sql_russian+="from bible_russian ";
				sql_russian+="where c4book_no='"+book+"' ";
				sql_russian+="and c5chapter_no='"+searchStr2+"' ";
				sql_russian+=" and c6verse_no>='"+searchStr3;
				sql_russian+="' and c6verse_no<='"+searchStr4+"';";


				sql_spanish="select c1content as content,";
				sql_spanish+="c5chapter_no as chapter,";
				sql_spanish+="c6verse_no as verse ";
				sql_spanish+="from bible_spanish ";
				sql_spanish+="where c4book_no='"+book+"' ";
				sql_spanish+="and c5chapter_no='"+searchStr2+"' ";
				sql_spanish+=" and c6verse_no>='"+searchStr3;
				sql_spanish+="' and c6verse_no<='"+searchStr4+"';";


				sql_tagalong_tab="select c1content as content,";
				sql_tagalong_tab+="c5chapter_no as chapter,";
				sql_tagalong_tab+="c6verse_no as verse ";
				sql_tagalong_tab+="from bible_tagalong_tab ";
				sql_tagalong_tab+="where c4book_no='"+book+"' ";
				sql_tagalong_tab+="and c5chapter_no='"+searchStr2+"' ";
				sql_tagalong_tab+=" and c6verse_no>='"+searchStr3;
				sql_tagalong_tab+="' and c6verse_no<='"+searchStr4+"';";


				sql_tamil="select c1content as content,";
				sql_tamil+="c5chapter_no as chapter,";
				sql_tamil+="c6verse_no as verse ";
				sql_tamil+="from bible_tamil ";
				sql_tamil+="where c4book_no='"+book+"' ";
				sql_tamil+="and c5chapter_no='"+searchStr2+"' ";
				sql_tamil+=" and c6verse_no>='"+searchStr3;
				sql_tamil+="' and c6verse_no<='"+searchStr4+"';";


				sql_thailand="select c1content as content,";
				sql_thailand+="c5chapter_no as chapter,";
				sql_thailand+="c6verse_no as verse ";
				sql_thailand+="from bible_thailand ";
				sql_thailand+="where c4book_no='"+book+"' ";
				sql_thailand+="and c5chapter_no='"+searchStr2+"' ";
				sql_thailand+=" and c6verse_no>='"+searchStr3;
				sql_thailand+="' and c6verse_no<='"+searchStr4+"';";


				sql_turkish="select c1content as content,";
				sql_turkish+="c5chapter_no as chapter,";
				sql_turkish+="c6verse_no as verse ";
				sql_turkish+="from bible_turkish ";
				sql_turkish+="where c4book_no='"+book+"' ";
				sql_turkish+="and c5chapter_no='"+searchStr2+"' ";
				sql_turkish+=" and c6verse_no>='"+searchStr3;
				sql_turkish+="' and c6verse_no<='"+searchStr4+"';";

				sql="select * from bible where book='"+book;
				sql+="' and chapter='"+searchStr2;
				sql+="' and verse>='"+searchStr3;
				sql+="' and verse<='"+searchStr4+"';";

			ResultSet rs = statement.executeQuery(sql);
			ResultSet rs_kh = statement_kh.executeQuery(sql); // 현대어
			ResultSet rs_kn = statement_kn.executeQuery(sql); // 새번역
			ResultSet rs_ke = statement_ke.executeQuery(sql); // 쉬운 성경
			ResultSet rs_ko = statement_ko.executeQuery(sql); // 개역 한글 국한문
			ResultSet rs_kk = statement_kk.executeQuery(sql); // 킹제임스흠정역
			ResultSet rs_niv = statement_niv.executeQuery(sql); // NIV
			ResultSet rs_esv = statement_esv.executeQuery(sql); // ESV
			ResultSet rs_vietnam = statement_vietnam.executeQuery(sql_vietnam); // vietnam
			ResultSet rs_ek = statement_ek.executeQuery(sql); // KJV
			ResultSet rs_en = statement_en.executeQuery(sql); // NewKJV
			ResultSet rs_hb = statement_hb.executeQuery(sql_hb); // Hebrew
			ResultSet rs_gr = statement_gr.executeQuery(sql_gr); // Greek

			ResultSet rs_arabic = statement_arabic.executeQuery(sql_arabic); // arabic
			ResultSet rs_burmese = statement_burmese.executeQuery(sql_burmese); // burmese
			ResultSet rs_chinese_niv_sim = statement_chinese_niv_sim.executeQuery(sql_chinese_niv_sim); // chinese_niv_sim
			ResultSet rs_chinese_niv_tra = statement_chinese_niv_tra.executeQuery(sql_chinese_niv_tra); // chinese_niv_tra
			ResultSet rs_chinese_sim = statement_chinese_sim.executeQuery(sql_chinese_sim); // chinese_sim
			ResultSet rs_chinese_tra = statement_chinese_tra.executeQuery(sql_chinese_tra); // chinese_tra
			ResultSet rs_english_kjv = statement_english_kjv.executeQuery(sql_english_kjv); // english_kjv
			ResultSet rs_english_sev = statement_english_sev.executeQuery(sql_english_sev); // english_sev
			ResultSet rs_finnish = statement_finnish.executeQuery(sql_finnish); // finnish
			ResultSet rs_french = statement_french.executeQuery(sql_french); // french
			ResultSet rs_germand45 = statement_germand45.executeQuery(sql_germand45); // germand45
			ResultSet rs_greek = statement_greek.executeQuery(sql_greek); // greek
			ResultSet rs_hebrew = statement_hebrew.executeQuery(sql_hebrew); // hebrew
			ResultSet rs_hindi = statement_hindi.executeQuery(sql_hindi); // hindi
			ResultSet rs_Indonesia_int = statement_Indonesia_int.executeQuery(sql_Indonesia_int); // Indonesia_int
			ResultSet rs_italian = statement_italian.executeQuery(sql_italian); // italian
			ResultSet rs_japan_niv = statement_japan_niv.executeQuery(sql_japan_niv); // japan_niv
//			ResultSet rs_khmer_bsc = statement_khmer_bsc.executeQuery(sql_khmer_bsc); // khmer_bsc
			ResultSet rs_korean_skv = statement_korean_skv.executeQuery(sql_korean_skv); // korean_skv
			ResultSet rs_lao = statement_lao.executeQuery(sql_lao); // lao
			ResultSet rs_malay = statement_malay.executeQuery(sql_malay); // malay
			ResultSet rs_mongolia = statement_mongolia.executeQuery(sql_mongolia); // mongolia
			ResultSet rs_portuguese = statement_portuguese.executeQuery(sql_portuguese); // portuguese
			ResultSet rs_russian = statement_russian.executeQuery(sql_russian); // russian
			ResultSet rs_spanish = statement_spanish.executeQuery(sql_spanish); // spanish
			ResultSet rs_tagalong_tab = statement_tagalong_tab.executeQuery(sql_tagalong_tab); // tagalong_tab
//			ResultSet rs_tamil = statement_tamil.executeQuery(sql_tamil); // tamil
			ResultSet rs_thailand = statement_thailand.executeQuery(sql_thailand); // thailand
			ResultSet rs_turkish = statement_turkish.executeQuery(sql_turkish); // turkish

			/* 결과를 첫 행부터 끝 행까지 반복하며 출력합니다. */
			System.out.println(result);
			sb.append("<table>");
			boolean is_hebrew=true;
			boolean is_niv=true;
			boolean is_esv=true;

			boolean is_arabic = true;
			boolean is_burmese = true;
			boolean is_chinese_niv_sim = true;
			boolean is_chinese_niv_tra = true;
			boolean is_chinese_sim = true;
			boolean is_chinese_tra = true;
			boolean is_english_kjv = true;
			boolean is_english_sev = true;
			boolean is_finnish = true;
			boolean is_french = true;
			boolean is_germand45 = true;
			boolean is_greek = true;
			boolean is_hindi = true;
			boolean is_Indonesia_int = true;
			boolean is_italian = true;
			boolean is_japan_niv = true;
			boolean is_khmer_bsc = true;
			boolean is_korean_skv = true;
			boolean is_lao = true;
			boolean is_malay = true;
			boolean is_mongolia = true;
			boolean is_portuguese = true;
			boolean is_russian = true;
			boolean is_spanish = true;
			boolean is_tagalong_tab = true;
			boolean is_tamil = true;
			boolean is_thailand = true;
			boolean is_turkish = true;



			while(rs.next())
			{
				rs_kh.next();
				rs_kn.next();
				rs_ke.next();
				rs_ko.next();
				rs_kk.next();
				rs_vietnam.next();
				if(!rs_arabic.next()){
					is_arabic            =false;
				}
				if(!rs_burmese.next()){
					is_burmese           =false;
				}
				if(!rs_chinese_niv_sim.next()){
					is_chinese_niv_sim   =false;
				}
				if(!rs_chinese_niv_tra.next()){
					is_chinese_niv_tra   =false;
				}
				if(!rs_chinese_sim.next()){
					is_chinese_sim       =false;
				}
				if(!rs_chinese_tra.next()){
					is_chinese_tra       =false;
				}
				if(!rs_english_kjv.next()){
					is_english_kjv       =false;
				}
				if(!rs_english_sev.next()){
					is_english_sev       =false;
				}
				if(!rs_finnish.next()){
					is_finnish           =false;
				}
				if(!rs_french.next()){
					is_french            =false;
				}
				if(!rs_germand45.next()){
					is_germand45         =false;
				}
				if(!rs_greek.next()){
					is_greek             =false;
				}
				if(!rs_hebrew.next()){
					is_hebrew            =false;
				}
				if(!rs_hindi.next()){
					is_hindi             =false;
				}
				if(!rs_Indonesia_int.next()){
					is_Indonesia_int     =false;
				}
				if(!rs_italian.next()){
					is_italian           =false;
				}
				if(!rs_japan_niv.next()){
					is_japan_niv         =false;
				}
				/*
				if(!rs_khmer_bsc.next()){
					is_khmer_bsc         =false;
				}
				*/
				if(!rs_korean_skv.next()){
					is_korean_skv        =false;
				}
				if(!rs_lao.next()){
					is_lao               =false;
				}
				if(!rs_malay.next()){
					is_malay             =false;
				}
				if(!rs_mongolia.next()){
					is_mongolia          =false;
				}
				if(!rs_portuguese.next()){
					is_portuguese        =false;
				}
				if(!rs_russian.next()){
					is_russian           =false;
				}
				if(!rs_spanish.next()){
					is_spanish           =false;
				}
				if(!rs_tagalong_tab.next()){
					is_tagalong_tab      =false;
				}
				/*
				if(!rs_tamil.next()){
					is_tamil             =false;
				}
				*/
				if(!rs_thailand.next()){
					is_thailand          =false;
				}
				if(!rs_turkish.next()){
					is_turkish           =false;
				}

				if(!rs_hb.next()){
					is_hebrew=false;
				}
				
				if(!rs_niv.next()){
					is_niv=false;
				}

				if(!rs_esv.next()){
					is_esv=false;
				}
				
				rs_gr.next();

				String  chapters = rs.getString("chapter");
				String  verse = rs.getString("verse");

 				sb.append("<tr><td>");
				 sb.append("<span class='korNKRV'>");
				sb.append("개역개정");
				sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append(rs.getString("content"));
				 sb.append("\n");
				 sb.append("</span>");
				sb.append("</td></tr><tr><td>");
				 sb.append("현대어");
				 sb.append("<span class='korTKV'>");
				sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append(rs_kh.getString("content"));
				 sb.append("\n");
				 sb.append("</span>");
				sb.append("</td></tr><tr><td>");
				 sb.append("새번역");
				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append(rs_kn.getString("content"));
				sb.append("</td></tr><tr><td>");
				 sb.append("쉬운 성경");
 				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append(rs_ke.getString("content"));
				sb.append("</td></tr>");
				 sb.append("<tr><td>");
				 sb.append("개역 한글 국한문   ");
				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append(rs_ko.getString("content"));
				sb.append("</td></tr>");

				sb.append("<tr><td>");
				sb.append("킹제임스흠정역");
				sb.append("</td><td>");
				sb.append(verse+" ");
				sb.append(rs_kk.getString("content"));
 				sb.append("</td></tr>");
				
				if(is_niv)
				{

				 sb.append("<tr><td>");
				 sb.append("NIV");
				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append(rs_niv.getString("content"));
				sb.append("</td></tr>");
				}else{
 				 sb.append("<tr><td>");
				 sb.append("NIV");
 				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append("없음");
				 sb.append("</td></tr>");
				}
				 sb.append("<tr><td>");
				 sb.append("vietnam");
				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append(rs_vietnam.getString("content"));
				sb.append("</td></tr>");


				if(is_esv)
				{

				 sb.append("<tr><td>");
				 sb.append("ESV");
				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append(rs_esv.getString("content"));
				sb.append("</td></tr>");
				}else{
 				 sb.append("<tr><td>");
				 sb.append("ESV");
 				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append("없음");
				 sb.append("</td></tr>");
				}

				 sb.append("<tr><td>");
				 sb.append("KJV");
				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append(rs_ek.getString("content"));
				sb.append("</td></tr>");

				 sb.append("<tr><td>");
				 sb.append("NewKJV");
				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append(rs_en.getString("content"));
				sb.append("</td></tr>");
				



				if(is_arabic)
				{

				 sb.append("<tr><td>");
				 sb.append("arabic");
				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append(rs_arabic.getString("content"));
				sb.append("</td></tr>");
				}else{
 				 sb.append("<tr><td>");
				 sb.append("arabic");
 				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append("없음");
				 sb.append("</td></tr>");
				}


				if(is_burmese)
				{

				 sb.append("<tr><td>");
				 sb.append("burmese");
				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append(rs_burmese.getString("content"));
				sb.append("</td></tr>");
				}else{
 				 sb.append("<tr><td>");
				 sb.append("burmese");
 				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append("없음");
				 sb.append("</td></tr>");
				}


				if(is_chinese_niv_sim)
				{

				 sb.append("<tr><td>");
				 sb.append("chinese_niv_sim");
				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append(rs_chinese_niv_sim.getString("content"));
				sb.append("</td></tr>");
				}else{
 				 sb.append("<tr><td>");
				 sb.append("chinese_niv_sim");
 				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append("없음");
				 sb.append("</td></tr>");
				}


				if(is_chinese_niv_tra)
				{

				 sb.append("<tr><td>");
				 sb.append("chinese_niv_tra");
				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append(rs_chinese_niv_tra.getString("content"));
				sb.append("</td></tr>");
				}else{
 				 sb.append("<tr><td>");
				 sb.append("chinese_niv_tra");
 				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append("없음");
				 sb.append("</td></tr>");
				}


				if(is_chinese_sim)
				{

				 sb.append("<tr><td>");
				 sb.append("chinese_sim");
				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append(rs_chinese_sim.getString("content"));
				sb.append("</td></tr>");
				}else{
 				 sb.append("<tr><td>");
				 sb.append("chinese_sim");
 				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append("없음");
				 sb.append("</td></tr>");
				}


				if(is_chinese_tra)
				{

				 sb.append("<tr><td>");
				 sb.append("chinese_tra");
				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append(rs_chinese_tra.getString("content"));
				sb.append("</td></tr>");
				}else{
 				 sb.append("<tr><td>");
				 sb.append("chinese_tra");
 				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append("없음");
				 sb.append("</td></tr>");
				}


				if(is_english_kjv)
				{

				 sb.append("<tr><td>");
				 sb.append("english_kjv");
				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append(rs_english_kjv.getString("content"));
				sb.append("</td></tr>");
				}else{
 				 sb.append("<tr><td>");
				 sb.append("english_kjv");
 				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append("없음");
				 sb.append("</td></tr>");
				}


				if(is_english_sev)
				{

				 sb.append("<tr><td>");
				 sb.append("english_sev");
				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append(rs_english_sev.getString("content"));
				sb.append("</td></tr>");
				}else{
 				 sb.append("<tr><td>");
				 sb.append("english_sev");
 				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append("없음");
				 sb.append("</td></tr>");
				}


				if(is_finnish)
				{

				 sb.append("<tr><td>");
				 sb.append("finnish");
				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append(rs_finnish.getString("content"));
				sb.append("</td></tr>");
				}else{
 				 sb.append("<tr><td>");
				 sb.append("finnish");
 				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append("없음");
				 sb.append("</td></tr>");
				}


				if(is_french)
				{

				 sb.append("<tr><td>");
				 sb.append("french");
				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append(rs_french.getString("content"));
				sb.append("</td></tr>");
				}else{
 				 sb.append("<tr><td>");
				 sb.append("french");
 				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append("없음");
				 sb.append("</td></tr>");
				}


				if(is_germand45)
				{

				 sb.append("<tr><td>");
				 sb.append("germand45");
				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append(rs_germand45.getString("content"));
				sb.append("</td></tr>");
				}else{
 				 sb.append("<tr><td>");
				 sb.append("germand45");
 				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append("없음");
				 sb.append("</td></tr>");
				}


				if(is_greek)
				{

				 sb.append("<tr><td>");
				 sb.append("greek");
				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append(rs_greek.getString("content"));
				 sb.append("\n");
				 sb.append("<a href='javascript:set_greek(\"");
				 sb.append(arrTables[2][Integer.parseInt(rs_greek.getString("book_no"))]);
				 sb.append("\",\"");
				 sb.append(rs_hebrew.getString("chapter"));
				 sb.append("\",\"");
				 sb.append(verse);
				 sb.append("\")'>원문보기</a>");

				sb.append("</td></tr>");
				}else{
 				 sb.append("<tr><td>");
				 sb.append("greek");
 				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append("없음");
				 sb.append("</td></tr>");
				}


				if(is_hebrew)
				{

				 sb.append("<tr><td>");
				 sb.append("hebrew");
				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append(rs_hebrew.getString("content"));
				 sb.append("\n");
				 sb.append("<a href='javascript:set_hebrew(\"");
				 sb.append(arrTables[2][Integer.parseInt(rs_hebrew.getString("book_no"))]);
				 sb.append("\",\"");
				 sb.append(rs_hebrew.getString("chapter"));
				 sb.append("\",\"");
				 sb.append(verse);
				 sb.append("\")'>원문보기</a>");
				sb.append("</td></tr>");
				}else{
 				 sb.append("<tr><td>");
				 sb.append("hebrew");
 				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append("없음");
				 sb.append("</td></tr>");
				}


				if(is_hindi)
				{

				 sb.append("<tr><td>");
				 sb.append("hindi");
				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append(rs_hindi.getString("content"));
				sb.append("</td></tr>");
				}else{
 				 sb.append("<tr><td>");
				 sb.append("hindi");
 				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append("없음");
				 sb.append("</td></tr>");
				}


				if(is_Indonesia_int)
				{

				 sb.append("<tr><td>");
				 sb.append("Indonesia_int");
				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append(rs_Indonesia_int.getString("content"));
				sb.append("</td></tr>");
				}else{
 				 sb.append("<tr><td>");
				 sb.append("Indonesia_int");
 				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append("없음");
				 sb.append("</td></tr>");
				}


				if(is_italian)
				{

				 sb.append("<tr><td>");
				 sb.append("italian");
				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append(rs_italian.getString("content"));
				sb.append("</td></tr>");
				}else{
 				 sb.append("<tr><td>");
				 sb.append("italian");
 				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append("없음");
				 sb.append("</td></tr>");
				}


				if(is_japan_niv)
				{

				 sb.append("<tr><td>");
				 sb.append("japan_niv");
				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append(rs_japan_niv.getString("content"));
				sb.append("</td></tr>");
				}else{
 				 sb.append("<tr><td>");
				 sb.append("japan_niv");
 				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append("없음");
				 sb.append("</td></tr>");
				}
/*

				if(is_khmer_bsc)
				{

				 sb.append("<tr><td>");
				 sb.append("khmer_bsc");
				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append(rs_khmer_bsc.getString("content"));
				sb.append("</td></tr>");
				}else{
 				 sb.append("<tr><td>");
				 sb.append("khmer_bsc");
 				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append("없음");
				 sb.append("</td></tr>");
				}

*/
				if(is_korean_skv)
				{

				 sb.append("<tr><td>");
				 sb.append("korean_skv");
				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append(rs_korean_skv.getString("content"));
				sb.append("</td></tr>");
				}else{
 				 sb.append("<tr><td>");
				 sb.append("korean_skv");
 				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append("없음");
				 sb.append("</td></tr>");
				}


				if(is_lao)
				{

				 sb.append("<tr><td>");
				 sb.append("lao");
				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append(rs_lao.getString("content"));
				sb.append("</td></tr>");
				}else{
 				 sb.append("<tr><td>");
				 sb.append("lao");
 				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append("없음");
				 sb.append("</td></tr>");
				}


				if(is_malay)
				{

				 sb.append("<tr><td>");
				 sb.append("malay");
				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append(rs_malay.getString("content"));
				sb.append("</td></tr>");
				}else{
 				 sb.append("<tr><td>");
				 sb.append("malay");
 				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append("없음");
				 sb.append("</td></tr>");
				}


				if(is_mongolia)
				{

				 sb.append("<tr><td>");
				 sb.append("mongolia");
				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append(rs_mongolia.getString("content"));
				sb.append("</td></tr>");
				}else{
 				 sb.append("<tr><td>");
				 sb.append("mongolia");
 				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append("없음");
				 sb.append("</td></tr>");
				}


				if(is_portuguese)
				{

				 sb.append("<tr><td>");
				 sb.append("portuguese");
				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append(rs_portuguese.getString("content"));
				sb.append("</td></tr>");
				}else{
 				 sb.append("<tr><td>");
				 sb.append("portuguese");
 				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append("없음");
				 sb.append("</td></tr>");
				}


				if(is_russian)
				{

				 sb.append("<tr><td>");
				 sb.append("russian");
				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append(rs_russian.getString("content"));
				sb.append("</td></tr>");
				}else{
 				 sb.append("<tr><td>");
				 sb.append("russian");
 				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append("없음");
				 sb.append("</td></tr>");
				}


				if(is_spanish)
				{

				 sb.append("<tr><td>");
				 sb.append("spanish");
				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append(rs_spanish.getString("content"));
				sb.append("</td></tr>");
				}else{
 				 sb.append("<tr><td>");
				 sb.append("spanish");
 				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append("없음");
				 sb.append("</td></tr>");
				}


				if(is_tagalong_tab)
				{

				 sb.append("<tr><td>");
				 sb.append("tagalong_tab");
				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append(rs_tagalong_tab.getString("content"));
				sb.append("</td></tr>");
				}else{
 				 sb.append("<tr><td>");
				 sb.append("tagalong_tab");
 				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append("없음");
				 sb.append("</td></tr>");
				}
/*

				if(is_tamil)
				{

				 sb.append("<tr><td>");
				 sb.append("tamil");
				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append(rs_tamil.getString("content"));
				sb.append("</td></tr>");
				}else{
 				 sb.append("<tr><td>");
				 sb.append("tamil");
 				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append("없음");
				 sb.append("</td></tr>");
				}

*/
				if(is_thailand)
				{

				 sb.append("<tr><td>");
				 sb.append("thailand");
				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append(rs_thailand.getString("content"));
				sb.append("</td></tr>");
				}else{
 				 sb.append("<tr><td>");
				 sb.append("thailand");
 				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append("없음");
				 sb.append("</td></tr>");
				}


				if(is_turkish)
				{

				 sb.append("<tr><td>");
				 sb.append("turkish");
				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append(rs_turkish.getString("content"));
				sb.append("</td></tr>");
				}else{
 				 sb.append("<tr><td>");
				 sb.append("turkish");
 				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append("없음");
				 sb.append("</td></tr>");
				}


				
				if(is_hebrew)
				{
				sb.append("<tr><td>");
				 sb.append("Hebrew");
 				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append(rs_hb.getString("content"));
				sb.append("</td></tr>");
				}else{
 				 sb.append("<tr><td>");
				 sb.append("Hebrew");
 				 sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append("없음");
				 sb.append("</td></tr>");
				}
				sb.append("<tr><td>");
				 sb.append("Greek");
				sb.append("</td><td>");
				 sb.append(verse+" ");
				 sb.append(rs_gr.getString("content"));
				 sb.append("\n");

				 
				 if(hasOption)
				{
				 sb.append("- ");
				 sb.append("\n\n");
				}


				sb.append("</td></tr>");
			}
			sb.append("</table>");
			/* resultSet 닫기 */
			rs.close();
			rs_kn.close();

			/* DB와의 연결 닫기 */
			connection.close();

			System.out.println(sb);
		}
  }

	/**
	 * 
	 */
	public static void showUsage() {
		System.out.println("성경 요절이나 성구의 키워드만 넣으면 검색이 됩니다.");
		System.out.println("");
		System.out.println("java  -cp \".;c:\\Bible\\sqlite-jdbc-3.16.1.jar\" Program[성경버전성경이름 or 약어 이름][경로 장[:]절]");

		System.out.println("  /A          주석 및 등장인물의 이름을 출력 합니다.");
		System.out.println("인자가 1개 이상 숫자를 포함하는 경우");
		System.out.println("사용예2:java Program 창1:2");
		System.out.println("사용예3:java Program 창1:2-3");
		System.out.println("사용예4:java Program 창세기1");
		System.out.println("사용예5:java Program 창세기1:2");
		System.out.println("사용예6:java Program 창세기1:2-3");
		System.out.println("사용예7:java Program 창 1");
		System.out.println("사용예8:java Program 창 1:2");
		System.out.println("사용예9:java Program 창 1:2-3");
		System.out.println("사용예10:java Program 창세기 1");
		System.out.println("사용예11:java Program 창세기 1:2");
		System.out.println("사용예12:java Program 창세기 1:2-3");
		System.out.println("사용예13:java Program 동방 박사");
		System.out.println("사용예15[개역개정한글]:java Program 창1:1 ");
		System.out.println("사용예14[현대어]:java Program kh창1:1 ");
		System.out.println("사용예15[새번역]:java Program kn창1:1 ");
		System.out.println("사용예16[쉬운성경]:java Program ke창1:1 ");
		System.out.println("사용예17[개역한글국한문]:java Program ko창1:1 ");
		System.out.println("사용예18[킹제임스흠정역]:java Program kk창1:1 ");
		System.out.println("사용예19[킹제임스영문]:java Program ek창1:1 ");
		System.out.println("사용예20[뉴킹제임스영문]:java Program en창1:1 ");
		System.out.println("사용예21[웨스터민스터 신앙고백서 1장1항]:java Program 웨1:1 ");

	}	
}
