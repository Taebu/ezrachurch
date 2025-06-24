import java.net.DatagramPacket;
import java.net.DatagramSocket;
import java.net.InetAddress;
import java.util.*;

public class UDPClient {
    public static void main(String[] args){
        // 키보드 입력 받기 위한 변수
        try{
            Scanner scanner = new Scanner(System.in);
            System.out.print("별명을 입력하세요 :");
            String name = scanner.next();
            // 출처: https://ddoriya.tistory.com/entry/JAVA-Multicast-Server-Client-Socket [또리야 개발하자:티스토리]          
            String msg = "";  
            while(true)
            {
                // Create a scanner object
                msg = name+" : "+scanner.nextLine();
                
                // 전송할 수 있는 UDP 소켓 생성
                DatagramSocket dsoc = new DatagramSocket();
                // 받을 곳의 주소 생성
                InetAddress ia = InetAddress.getByName("127.0.0.1");
                // 전송할 데이터 생성
                DatagramPacket dp = new DatagramPacket(msg.getBytes(),msg.getBytes().length,ia, 7777);
                //epdlxj wjsthd
                dsoc.send(dp);
                dsoc.close();
            }
        }catch(Exception e){
            System.out.println(e.getMessage());
        }
    }
}
// 출처: https://ddoriya.tistory.com/entry/JAVA-UDP-server-Client-만들기 [또리야 개발하자:티스토리]