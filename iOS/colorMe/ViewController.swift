//
//  ViewController.swift
//  colorMe
//
//  Created by Andrew Myers on 3/25/17.
//  Copyright © 2017 Andrew Myers. All rights reserved.
//

import UIKit


class ViewController: UIViewController, ISColorWheelDelegate {
	
	var currentColor: UIColor = UIColor.white
    
    var colorWheel: ISColorWheel? = nil
    var brightnessSlider: UISlider? = nil
	var submitButton: UIButton? = nil
	
	var phone = "2169566397"
	
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
        self.view.addSubview(brightnessSlider!)
		
		// #### SUBMIT BUTTON #### //
		
		submitButton = UIButton(frame: CGRect(x: size.width * 0.1, y: size.height*0.85, width: size.width * 0.8, height: size.height * 0.1));
		submitButton?.layer.borderColor = UIColor.white.cgColor
		submitButton?.layer.borderWidth = 3.0
		submitButton?.backgroundColor = currentColor
		
		submitButton?.setTitle("Submit", for: .normal)
		submitButton?.addTarget(self, action: #selector(changeColor), for: .touchUpInside)
		
		self.view.addSubview(submitButton!)

		currentColor = getColorFromDatabase()
		//print(currentColor)
		//self.view.backgroundColor = self.currentColor
        
    }
	
	override func viewDidAppear(_ animated: Bool) {
		//self.view.backgroundColor = self.currentColor
	}

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    
    func changeBrightness(slider: UISlider){
        colorWheel?.brightness = CGFloat((brightnessSlider?.value)!)
        self.submitButton?.backgroundColor = colorWheel?.currentColor
    }
	
    func colorWheelDidChangeColor(_ colorWheel: ISColorWheel!) {
        self.submitButton?.backgroundColor = colorWheel?.currentColor

    }
	
	func changeColor()
	{
		self.currentColor = (colorWheel?.currentColor)!
		self.view.backgroundColor = self.currentColor
		
		let color = hexStringFromColor(color: self.currentColor)
		
		let scriptUrl = "http://174.138.95.169/setColor.php?phone="+phone+"&color="+color
		print(scriptUrl)
		let myUrl = URL(string: scriptUrl)
		let request = NSMutableURLRequest(url:myUrl!)
		request.httpMethod = "GET"
		
		let task = URLSession.shared.dataTask(with:myUrl!) { (data, response, error) in
			
			// Check for error
			if error != nil
			{
				print("error=\(error)")
				return
			}
			
			// Print out response string
			let responseString = NSString(data: data!, encoding: String.Encoding.utf8.rawValue)
			print("responseString = \(responseString)")
			
			
		}
		
		task.resume()
	}
	
	func hexStringFromColor(color: UIColor) -> String {
		var comps: [CGFloat] = color.cgColor.components!
		let r: CGFloat = comps[0]
		let g: CGFloat = comps[1]
		let b: CGFloat = comps[2]
		return String.localizedStringWithFormat("%02lX%02lX%02lX", lroundf(Float(CGFloat(r * 255))),
		                                        lroundf(Float(CGFloat(g * 255))),
		                                        lroundf(Float(CGFloat(b * 255))))
	}
	
	func getColorFromDatabase() -> UIColor {
		
		let scriptUrl = "http://174.138.95.169/getColorFromPhone.php?phone="+phone
		print(scriptUrl)
		let myUrl = URL(string: scriptUrl)
		
		var color: UIColor = UIColor.white;
		var r: Int = 0;
		var g: Int = 0;
		var b: Int = 0;
		
		let task = URLSession.shared.dataTask(with:myUrl!) { (data, response, error) in
			if error != nil {
				print(error)
			} else {
				do {
					
					let parsedData = try JSONSerialization.jsonObject(with: data!, options: []) as! [String:Int]
					print(parsedData)
					
					r = parsedData["r"]! as Int
					g = parsedData["g"]! as Int
					b = parsedData["b"]! as Int
					
					print(r,g,b)
					
					color = UIColor(colorLiteralRed: Float(Double(r)/255.0), green: Float(Double(g)/255.0), blue: Float(Double(b)/255.0), alpha: 1.0)
					self.view.backgroundColor = color
					print(color)
					//color = UIColor(red: CGFloat(Double(r)/255.0), green: CGFloat(Double(g)/255.0), blue: CGFloat(Double(b)/255.0), alpha: 1.0)
					
					//print(parsedData)
					
				
				} catch let error as NSError {
					print(error)
				}
			}
			}
		
		task.resume()

		return color;//UIColor(red: CGFloat(Double(r)/255.0), green: CGFloat(Double(g)/255.0), blue: CGFloat(Double(b)/255.0), alpha: 1.0)
	}
	


}


