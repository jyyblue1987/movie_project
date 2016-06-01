package com.sin.movies.pages;

import org.json.JSONException;
import org.json.JSONObject;

import com.sin.movies.Const;
import com.sin.movies.R;
import com.sin.movies.network.ServerManager;

import android.content.Context;
import android.net.wifi.WifiInfo;
import android.net.wifi.WifiManager;
import android.os.Build;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import common.library.utils.CheckUtils;
import common.library.utils.DataUtils;
import common.library.utils.MessageUtils;
import common.manager.activity.ActivityManager;
import common.network.utils.LogicResult;
import common.network.utils.ResultCallBack;

public class LoginActivity extends BaseActivity {
	EditText	m_editDeviceID = null;
	Button		m_btnLogin = null;
	
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.layout_login);
		
		loadComponents();
	}
	
	protected void findViews()
	{
		super.findViews();

	}
	
	protected void initData()
	{
		super.initData();
		
		WifiManager wifiManager = (WifiManager) getSystemService(Context.WIFI_SERVICE);
        WifiInfo wInfo = wifiManager.getConnectionInfo();
        String macAddress = wInfo.getMacAddress(); 
        String serialno = Build.SERIAL;
        
        login(macAddress, serialno);
		//gotoCategoryListPage();
	}
	
	protected void initEvents()
	{ 
		super.initEvents();
		
		

		
	}
	
	 private void onClickLogin()
	 {
		 
	 }

	 private void login(final String macaddress, String serialno)
	 {
		 DataUtils.savePreference(Const.MACADDRESS, macaddress);
		 DataUtils.savePreference(Const.SERIALNO, serialno);
		 	
		 showLoadingProgress();
		 ServerManager.login(macaddress, serialno, new ResultCallBack() {
			 
			@Override
			public void doAction(LogicResult result) {
				hideProgress();
				
				JSONObject data = result.getData();
				if( data == null)
				{
					 MessageUtils.showMessageDialog(LoginActivity.this, data.optString("message", "Server is not responding"));
					return;
				}
				String content = "0";
				try {
					content = data.getString("content");
				} catch (JSONException e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
				}
				if(content.equals("1")){
					gotoCategoryListPage();
				}else{
					MessageUtils.showMessageDialog(LoginActivity.this, data.optString("message", "invalid device."));
				}
				
				//DataUtils.savePreference(Const.USER_ID, data.optString(Const.USER_ID, ""));
				
			}
		});
	 }
	 
	 private void gotoCategoryListPage()
	 {
		Bundle bundle = new Bundle();
		ActivityManager.changeActivity(this, CategoryActivity.class, bundle, true, null );
	 }
	 
	 
}

