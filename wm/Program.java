import java.nio.charset.Charset;
import java.sql.*;
import java.util.HashMap;
import java.util.Map;

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
			"히", "약", "벧전", "벧후", "요일", "요이", "요삼", "유", "계","교","웨"} };

	

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
			System.out.println();
			System.out.println("올바른 사용 방법이 아닙니다. 아래 방법을 참고 해 주세요.");
			System.out.println();
			showUsage();
		}catch(StringIndexOutOfBoundsException e){
			System.out.println();
			System.out.println("올바른 사용 방법이 아닙니다. 아래 방법을 참고 해 주세요.");
			System.out.println();
			showUsage();
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
			System.out.println();
			System.out.println("올바른 사용 방법이 아닙니다. 아래 방법을 참고 해 주세요.");
			System.out.println();
			showUsage();
		}catch(StringIndexOutOfBoundsException e){
			System.out.println();
			System.out.println("올바른 사용 방법이 아닙니다. 아래 방법을 참고 해 주세요.");
			System.out.println();
			showUsage();
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


	/******************************************************
	* Program java main 함수
	*
	*
	*
	*
	*
	*
	*
	*
	*
	*
	*
	*
	*
	*
	*
	*
	*
	*
	*
	******************************************************/
	public static void main(String[] args) throws Exception
	{
		Connection connection = null;
		Statement statement = null;
		Program pg=new Program();
		
		String version=pg.get_version(args);
		String version_name=pg.get_version_name(args);

		String book="";
		String chapter=pg.get_chapter(args);
		String s = "";
		String searchStr1="",searchStr2="",searchStr3="",searchStr4="";
		boolean is_west=false;		
		
		String tmpA="";

		/**
		* 키워드 검색 인지 구절 검색인지 판단, 
		* 기본값은 'false'로 구절 검색이다. 
		*/
		boolean isKeywordSearch = false;
		isKeywordSearch = pg.isKeyword(args);
		/* 장절 검색 */
		tmpA=pg.search_verse(args);



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
			System.out.println("PC");
			System.out.println("java -cp \".;c:\\Bible\\sqlite-jdbc-3.16.1.jar\" Program 창1:1");
			System.out.println("Linux ");
			System.out.println("java -cp \".:./sqlite-jdbc-3.16.1.jar\" Program 창1:1");
			System.out.println("");
			System.out.println("에러시 위의 옵션을 추가 바랍니다.");
		}

		/* Program.class와 같은 디렉터리에 있는 test.db를 엽니다. */
		String location=new java.io.File( "." ).getCanonicalPath();

		location=location.replaceAll("\\\\", "/");
//	     connection = DriverManager.getConnection("jdbc:sqlite:"+location+"/KORTKV.db");
	     connection = DriverManager.getConnection("jdbc:sqlite:"+location+"/db/"+version);

		
		/* 연결 성공했을 때, connection으로부터 statement 인스턴스를 얻습니다. 여기서 SQL 구문을 수행합니다. */
		statement = connection.createStatement();

		/* 아래는 SQL 예시입니다. */
		/* Table1이라는 테이블 안에 field1(text형), field2(integer형)라는 이름의 필드가 있다고 가정합니다. */
		//System.out.println("select * from Bible where book="+book+" and  chapter="+chapter+";");
		//ResultSet rs = statement.executeQuery("select * from Bible where book="+book+" and  chapter="+chapter+" and ;");
		String result="";
		String sql="";

		
		
		/* 검색어 검색*/
		if(isKeywordSearch){
			String searchstr="";
			int i=0;
			for(i=0;i<args.length;i++){
			searchstr+=" "+args[i].trim();
			}
			searchstr=searchstr.trim();
			sql="select *,replace(content,'"+searchstr+"','\""+searchstr+"\"') content2 from bible where content like '%"+searchstr+"%';";
			ResultSet rs=statement.executeQuery(sql);
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
			
			result=pg.strBookIndexFullName+" "+searchStr2+"장 "+searchStr3+"항 ["+version_name+"]";
			/* 결과를 첫 행부터 끝 행까지 반복하며 출력합니다. */
			System.out.println(result);
			while(rs.next())
			{

				String  wm_subject = rs.getString("wm_subject");
				String  content = rs.getString("wm_content");
				String  relparse = rs.getString("wm_relparse");

				 System.out.println("제 "+searchStr2+"장 "+searchStr3+"항");
				 if(wm_subject!=null)
				 {
				 	System.out.println(wm_subject);
				 }
				 System.out.println(content);
				 if(relparse!=null)
				 {
				 	System.out.print(relparse);
				 }

				 System.out.println();
				
			}
			/* resultSet 닫기 */
			rs.close();
			/* DB와의 연결 닫기 */
			connection.close();

		}

		if(!is_west)
		{
			if(version_name.equals("Hebrew"))
			{
				sql="select c1content as content,";
				sql+="c5chapter_no as chapter,";
				sql+="c6verse_no as verse ";
				sql+="from bible_hebrew ";
				sql+="where c4book_no='"+book+"' ";
				sql+="and c5chapter_no='"+searchStr2+"' ";
				sql+=" and c6verse_no>='"+searchStr3;
				sql+="' and c6verse_no<='"+searchStr4+"';";

			}else if(version_name.equals("Greek")){
				sql="select c1content as content,";
				sql+="c5chapter_no as chapter,";
				sql+="c6verse_no as verse ";
				sql+="from bible_greek ";
				sql+="where c4book_no='"+book+"' ";
				sql+="and c5chapter_no='"+searchStr2+"' ";
				sql+=" and c6verse_no>='"+searchStr3;
				sql+="' and c6verse_no<='"+searchStr4+"';";
			}else{
				sql="select * from bible where book='"+book;
				sql+="' and chapter='"+searchStr2;
				sql+="' and verse>='"+searchStr3;
				sql+="' and verse<='"+searchStr4+"';";
			}
			ResultSet rs = statement.executeQuery(sql);
			/* 결과를 첫 행부터 끝 행까지 반복하며 출력합니다. */
			System.out.println(result);
			while(rs.next())
			{
				String  chapters = rs.getString("chapter");
				String  verse = rs.getString("verse");

				
				 System.out.print(verse+" ");
				 System.out.print(rs.getString("content"));
				 
				 System.out.println();
				
			}
			/* resultSet 닫기 */
			rs.close();
			/* DB와의 연결 닫기 */
			connection.close();

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
		System.out.println("사용 예1:창1:2");
		System.out.println("사용 예2:창1:2-3");
		System.out.println("사용 예3:창1");
		System.out.println("사용 예4:창1:2");
		System.out.println("사용 예5:창1:2-3");
		System.out.println("사용 예6 [현대어]:");
		System.out.println("kh창1:1 ");
		System.out.println("사용 예7 [개역개정한글]:");
		System.out.println("창1:1 ");
		System.out.println("사용 예8 [새번역]:");
		System.out.println("kn창1:1 ");
		System.out.println("사용 예9 [쉬운성경]:");
		System.out.println("ke창1:1 ");
		System.out.println("사용 예10[개역한글국한문]:");
		System.out.println("ko창1:1 ");
		System.out.println("사용 예11[킹제임스흠정역]:");
		System.out.println("kk창1:1 ");
		System.out.println("사용 예12[킹제임스영문]:");
		System.out.println("ek창1:1 ");
		System.out.println("사용 예13[뉴킹제임스영문]:");
		System.out.println("en창1:1 ");
		System.out.println("사용 예14[웨스터민스터 신앙고백서 1장1항]:");
		System.out.println("웨1:1 ");
		System.out.println("사용 예15[헬라어 (그리스어)] :");
		System.out.println("gr창1:1 ");
		System.out.println("사용 예16[히브리어] :");
		System.out.println("hb창1:1 ");
		System.out.println("");
		System.out.println("");
		System.out.println("검색 사용 예:");
		System.out.println("동방 박사");

	}	
}