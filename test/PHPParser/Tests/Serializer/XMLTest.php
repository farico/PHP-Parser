<?php

class PHPParser_Tests_Serializer_XMLTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers PHPParser_Serializer_XML<extended>
     */
    public function testSerialize() {
        $code = <<<CODE
<?php
/** doc comment */
function functionName(&\$a = 0, \$b = 1.0) {
    echo 'Foo';
}
CODE;
        $xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<AST xmlns:node="http://nikic.github.com/PHPParser/XML/node" xmlns:subNode="http://nikic.github.com/PHPParser/XML/subNode" xmlns:attribute="http://nikic.github.com/PHPParser/XML/attribute" xmlns:scalar="http://nikic.github.com/PHPParser/XML/scalar">
 <scalar:array>
  <node:Stmt_Function>
   <attribute:line>
    <scalar:int>3</scalar:int>
   </attribute:line>
   <attribute:docComment>
    <scalar:string>/** doc comment */</scalar:string>
   </attribute:docComment>
   <subNode:byRef>
    <scalar:false/>
   </subNode:byRef>
   <subNode:params>
    <scalar:array>
     <node:Param>
      <attribute:line>
       <scalar:int>3</scalar:int>
      </attribute:line>
      <attribute:docComment>
       <scalar:null/>
      </attribute:docComment>
      <subNode:name>
       <scalar:string>a</scalar:string>
      </subNode:name>
      <subNode:default>
       <node:Scalar_LNumber>
        <attribute:line>
         <scalar:int>3</scalar:int>
        </attribute:line>
        <attribute:docComment>
         <scalar:null/>
        </attribute:docComment>
        <subNode:value>
         <scalar:int>0</scalar:int>
        </subNode:value>
       </node:Scalar_LNumber>
      </subNode:default>
      <subNode:type>
       <scalar:null/>
      </subNode:type>
      <subNode:byRef>
       <scalar:true/>
      </subNode:byRef>
     </node:Param>
     <node:Param>
      <attribute:line>
       <scalar:int>3</scalar:int>
      </attribute:line>
      <attribute:docComment>
       <scalar:null/>
      </attribute:docComment>
      <subNode:name>
       <scalar:string>b</scalar:string>
      </subNode:name>
      <subNode:default>
       <node:Scalar_DNumber>
        <attribute:line>
         <scalar:int>3</scalar:int>
        </attribute:line>
        <attribute:docComment>
         <scalar:null/>
        </attribute:docComment>
        <subNode:value>
         <scalar:float>1</scalar:float>
        </subNode:value>
       </node:Scalar_DNumber>
      </subNode:default>
      <subNode:type>
       <scalar:null/>
      </subNode:type>
      <subNode:byRef>
       <scalar:false/>
      </subNode:byRef>
     </node:Param>
    </scalar:array>
   </subNode:params>
   <subNode:stmts>
    <scalar:array>
     <node:Stmt_Echo>
      <attribute:line>
       <scalar:int>4</scalar:int>
      </attribute:line>
      <attribute:docComment>
       <scalar:null/>
      </attribute:docComment>
      <subNode:exprs>
       <scalar:array>
        <node:Scalar_String>
         <attribute:line>
          <scalar:int>4</scalar:int>
         </attribute:line>
         <attribute:docComment>
          <scalar:null/>
         </attribute:docComment>
         <subNode:value>
          <scalar:string>Foo</scalar:string>
         </subNode:value>
        </node:Scalar_String>
       </scalar:array>
      </subNode:exprs>
     </node:Stmt_Echo>
    </scalar:array>
   </subNode:stmts>
   <subNode:name>
    <scalar:string>functionName</scalar:string>
   </subNode:name>
  </node:Stmt_Function>
 </scalar:array>
</AST>
XML;

        $parser     = new PHPParser_Parser(new PHPParser_Lexer);
        $serializer = new PHPParser_Serializer_XML;

        $stmts = $parser->parse($code);
        $this->assertXmlStringEqualsXmlString($xml, $serializer->serialize($stmts));
    }

    /**
     * @expectedException        InvalidArgumentException
     * @expectedExceptionMessage Unexpected node type
     */
    public function testError() {
        $serializer = new PHPParser_Serializer_XML;
        $serializer->serialize(array(new stdClass));
    }
}