//
//  ViewController.swift
//  colorMe
//
//  Created by Andrew Myers on 3/25/17.
//  Copyright © 2017 Andrew Myers. All rights reserved.
//

import UIKit


class ViewController: UIViewController, ISColorWheelDelegate {
    
    var colorWheel: ISColorWheel? = nil
    var brightnessSlider: UISlider? = nil
    

    override func viewDidLoad() {
        super.viewDidLoad()
        
        // #### COLOR WHEEL #### //
        
        // Get size of screen and calculate size of wheel
        let size = self.view.bounds.size
        let wheelSize = CGSize(width: size.width*0.9, height: size.width*0.9)
        
        // Initialize color wheel
        colorWheel = ISColorWheel(frame: CGRect(x: size.width / 2 - wheelSize.width / 2,
                                                y: size.height * 0.1,
                                                width: wheelSize.width,
                                                height: wheelSize.height))
        
        colorWheel?.delegate = self
        colorWheel?.continuous = true
        
        // Add color wheel to view
        self.view.addSubview(colorWheel!)
        
        // #### COLOR SLIDER #### //

        // Initialize brightness slider
        brightnessSlider = UISlider(frame: CGRect(x: size.width * 0.1,
                                                  y: size.height * 0.2 + wheelSize.height,
                                                  width: size.width * 0.8,
                                                  height: size.height * 0.1))
        
        // Configure brightness slider
        brightnessSlider?.minimumValue = 0.0
        brightnessSlider?.maximumValue = 1.0
        brightnessSlider?.value = 1.0
        brightnessSlider?.isContinuous = true
        brightnessSlider?.addTarget(self, action: #selector(changeBrightness(slider:)), for: .valueChanged)
        
        // Add brightness slider to view
        self.view.addSubview(brightnessSlider!);
        
    }

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    
    func changeBrightness(slider: UISlider){
        colorWheel?.brightness = CGFloat((brightnessSlider?.value)!)
        self.view.backgroundColor = colorWheel?.currentColor
    }
    
    func colorWheelDidChangeColor(_ colorWheel: ISColorWheel!) {
        self.view.backgroundColor = colorWheel?.currentColor

    }


}


