package org.example;

import javax.net.ServerSocketFactory;
import java.io.IOException;
import java.net.ServerSocket;
import java.net.Socket;

public class Main {
    public static void main(String[] args) {
        try {
            ServerSocket serverSocket = ServerSocketFactory.getDefault().createServerSocket(8069, 10);
            while (true) {
                Socket socket = serverSocket.accept();
                Thread thread = new Thread(new HttpReplay(socket));
                thread.start();
            }
        } catch (IOException e) {
            e.printStackTrace();
        }
    }
}
