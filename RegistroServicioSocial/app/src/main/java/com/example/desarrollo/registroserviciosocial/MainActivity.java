package com.example.desarrollo.registroserviciosocial;

import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.EditText;
import android.widget.RadioButton;
import android.widget.Toast;

public class MainActivity extends AppCompatActivity {

    RadioButton radioId,radioQr;
    EditText idText;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        radioQr = findViewById(R.id.radioButtonQr);
        radioId = findViewById(R.id.radioButtonId);
        idText =  findViewById(R.id.edtxtId);


    }

    public void Cambio (View view){
        if (radioQr.isChecked() == true){
            idText.setVisibility(View.INVISIBLE);
        }
        if (radioId.isChecked() == true){
            idText.setVisibility(View.VISIBLE);
        }
    }
}
