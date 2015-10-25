<?php

#
# Dryuf framework
#
# ----------------------------------------------------------------------------------
#
# Copyright (C) 2000-2015 Zbyněk Vyškovský
#
# ----------------------------------------------------------------------------------
#
# LICENSE:
#
# This file is part of Dryuf
#
# Dryuf is free software; you can redistribute it and/or modify it under the
# terms of the GNU Lesser General Public License as published by the Free
# Software Foundation; either version 3 of the License, or (at your option)
# any later version.
#
# Dryuf is distributed in the hope that it will be useful, but WITHOUT ANY
# WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
# FOR A PARTICULAR PURPOSE.  See the GNU Lesser General Public License for
# more details.
#
# You should have received a copy of the GNU Lesser General Public License
# along with Dryuf; if not, write to the Free Software Foundation, Inc., 51
# Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
#
# @author	2000-2015 Zbyněk Vyškovský
# @link		mailto:kvr@matfyz.cz
# @link		http://kvr.matfyz.cz/software/java/dryuf/
# @link		http://github.com/dryuf/
# @license	http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License v3
#

namespace net\dryuf\service\mail\php;


class PhpEmailSender implements \net\dryuf\service\mail\EmailSender
{
	protected			$defaultFrom;

	function			mailUtf8($to, $subject, $content, $from)
	{
		if (is_null($from))
			$from = $this->defaultFrom;

		$headers = "From: ".$from."\n";
		$headers .= "MIME-Version: 1.0\n"; 
		$headers .= "Content-Type: text/plain; charset=UTF-8\n";
		$headers .="Content-Transfer-Encoding: 8bit\n";
		if (!\mail(
			$to,
			\net\dryuf\text\util\TextUtil::transliterate($subject),
			$content,
			$headers
		)) {
			throw new \net\dryuf\core\Exception("failed to send e-mail to $to");
		}
	}

	function			mailAttachment($to, $subject, $content, $from, $attachment)
	{
		if (is_null($from))
			$from = $this->defaultFrom;
		$filename = basename($attachment->getName());
		$file_size = $attachment->getSize();
		$base64 = chunk_split(base64_encode(stream_get_contents($attachment->getInputStream()))); 
		$uid = md5(uniqid(time()));
		$from = str_replace(array("\r", "\n"), '', $from);
		$headers = "From: ".$from."\n"
			."MIME-Version: 1.0\n"
			."Content-Type: multipart/mixed; boundary=\"".$uid."\"\n\n"
			."This is a multi-part message in MIME format.\n" 
			."--".$uid."\n"
			."Content-type:text/plain; charset=UTF-8\n"
			."Content-Transfer-Encoding: 8bit\n\n"
			.$content."\n\n"
			."--".$uid."\n"
			."Content-Type: application/octet-stream; name=\"".$filename."\"\n"
			."Content-Transfer-Encoding: base64\n"
			."Content-Disposition: attachment; filename=\"".$filename."\"\n\n"
			.$base64."\n\n"
			."--".$uid."--"; 
		if (!mail($to, \net\dryuf\service\text\Utf8::convertToAscii($subject), "", $headers)) {
			throw new \net\dryuf\core\Exception("failed to send e-mail to $to");
		}
	}
}


?>
