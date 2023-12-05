"use strict";/*!-----------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 * Version: 0.44.0(3e047efd345ff102c8c61b5398fb30845aaac166)
 * Released under the MIT license
 * https://github.com/microsoft/monaco-editor/blob/main/LICENSE.txt
 *-----------------------------------------------------------------------------*/
define("vs/basic-languages/hcl/hcl", ["require","require"],(require)=>{
var moduleExports=(()=>{var r=Object.defineProperty;var a=Object.getOwnPropertyDescriptor;var i=Object.getOwnPropertyNames;var c=Object.prototype.hasOwnProperty;var l=(t,e)=>{for(var o in e)r(t,o,{get:e[o],enumerable:!0})},d=(t,e,o,n)=>{if(e&&typeof e=="object"||typeof e=="function")for(let s of i(e))!c.call(t,s)&&s!==o&&r(t,s,{get:()=>e[s],enumerable:!(n=a(e,s))||n.enumerable});return t};var m=t=>d(r({},"__esModule",{value:!0}),t);var f={};l(f,{conf:()=>p,language:()=>g});var p={comments:{lineComment:"#",blockComment:["/*","*/"]},brackets:[["{","}"],["[","]"],["(",")"]],autoClosingPairs:[{open:"{",close:"}"},{open:"[",close:"]"},{open:"(",close:")"},{open:'"',close:'"',notIn:["string"]}],surroundingPairs:[{open:"{",close:"}"},{open:"[",close:"]"},{open:"(",close:")"},{open:'"',close:'"'}]},g={defaultToken:"",tokenPostfix:".hcl",keywords:["var","local","path","for_each","any","string","number","bool","true","false","null","if ","else ","endif ","for ","in","endfor"],operators:["=",">=","<=","==","!=","+","-","*","/","%","&&","||","!","<",">","?","...",":"],symbols:/[=><!~?:&|+\-*\/\^%]+/,escapes:/\\(?:[abfnrtv\\"']|x[0-9A-Fa-f]{1,4}|u[0-9A-Fa-f]{4}|U[0-9A-Fa-f]{8})/,terraformFunctions:/(abs|ceil|floor|log|max|min|pow|signum|chomp|format|formatlist|indent|join|lower|regex|regexall|replace|split|strrev|substr|title|trimspace|upper|chunklist|coalesce|coalescelist|compact|concat|contains|distinct|element|flatten|index|keys|length|list|lookup|map|matchkeys|merge|range|reverse|setintersection|setproduct|setunion|slice|sort|transpose|values|zipmap|base64decode|base64encode|base64gzip|csvdecode|jsondecode|jsonencode|urlencode|yamldecode|yamlencode|abspath|dirname|pathexpand|basename|file|fileexists|fileset|filebase64|templatefile|formatdate|timeadd|timestamp|base64sha256|base64sha512|bcrypt|filebase64sha256|filebase64sha512|filemd5|filemd1|filesha256|filesha512|md5|rsadecrypt|sha1|sha256|sha512|uuid|uuidv5|cidrhost|cidrnetmask|cidrsubnet|tobool|tolist|tomap|tonumber|toset|tostring)/,terraformMainBlocks:/(module|data|terraform|resource|provider|variable|output|locals)/,tokenizer:{root:[[/^@terraformMainBlocks([ \t]*)([\w-]+|"[\w-]+"|)([ \t]*)([\w-]+|"[\w-]+"|)([ \t]*)(\{)/,["type","","string","","string","","@brackets"]],[/(\w+[ \t]+)([ \t]*)([\w-]+|"[\w-]+"|)([ \t]*)([\w-]+|"[\w-]+"|)([ \t]*)(\{)/,["identifier","","string","","string","","@brackets"]],[/(\w+[ \t]+)([ \t]*)([\w-]+|"[\w-]+"|)([ \t]*)([\w-]+|"[\w-]+"|)(=)(\{)/,["identifier","","string","","operator","","@brackets"]],{include:"@terraform"}],terraform:[[/@terraformFunctions(\()/,["type","@brackets"]],[/[a-zA-Z_]\w*-*/,{cases:{"@keywords":{token:"keyword.$0"},"@default":"variable"}}],{include:"@whitespace"},{include:"@heredoc"},[/[{}()\[\]]/,"@brackets"],[/[<>](?!@symbols)/,"@brackets"],[/@symbols/,{cases:{"@operators":"operator","@default":""}}],[/\d*\d+[eE]([\-+]?\d+)?/,"number.float"],[/\d*\.\d+([eE][\-+]?\d+)?/,"number.float"],[/\d[\d']*/,"number"],[/\d/,"number"],[/[;,.]/,"delimiter"],[/"/,"string","@string"],[/'/,"invalid"]],heredoc:[[/<<[-]*\s*["]?([\w\-]+)["]?/,{token:"string.heredoc.delimiter",next:"@heredocBody.$1"}]],heredocBody:[[/([\w\-]+)$/,{cases:{"$1==$S2":[{token:"string.heredoc.delimiter",next:"@popall"}],"@default":"string.heredoc"}}],[/./,"string.heredoc"]],whitespace:[[/[ \t\r\n]+/,""],[/\/\*/,"comment","@comment"],[/\/\/.*$/,"comment"],[/#.*$/,"comment"]],comment:[[/[^\/*]+/,"comment"],[/\*\//,"comment","@pop"],[/[\/*]/,"comment"]],string:[[/\$\{/,{token:"delimiter",next:"@stringExpression"}],[/[^\\"\$]+/,"string"],[/@escapes/,"string.escape"],[/\\./,"string.escape.invalid"],[/"/,"string","@popall"]],stringInsideExpression:[[/[^\\"]+/,"string"],[/@escapes/,"string.escape"],[/\\./,"string.escape.invalid"],[/"/,"string","@pop"]],stringExpression:[[/\}/,{token:"delimiter",next:"@pop"}],[/"/,"string","@stringInsideExpression"],{include:"@terraform"}]}};return m(f);})();
return moduleExports;
});
