require 'fileutils'
Dir.glob("*test/*").each do |original_file|
underscore_file = original_file.gsub(" ","_")
if(underscore_file != original_file)
	FileUtils.mv(original_file,underscore_file)
	puts "Renamed:  #{original_file} =&gt; #{underscore_file}"
end

end