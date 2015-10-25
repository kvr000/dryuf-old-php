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

namespace net\dryuf\dao\phpjpa\parser;


abstract class ParserTree
{
	const				PTK_None		= 0;
	const				PTK_Null		= 1;
	const				PTK_Number		= 2;
	const				PTK_String		= 3;
	const				PTK_Star		= 4;
	const				PTK_Identifier		= 5;
	const				PTK_Member		= 6;
	const				PTK_Call		= 7;
	const				PTK_Expression		= 8;
	const				PTK_Parenthesized	= 9;
	const				PTK_SelectItem		= 10;
	const				PTK_FromSource		= 11;
	const				PTK_TableSource		= 12;
	const				PTK_SubSource		= 13;
	const				PTK_Tuple		= 14;
	const				PTK_OrderByItem		= 15;

	const				PTK_UnaryPlus		= 20;
	const				PTK_UnaryMinus		= 21;
	const				PTK_UnaryNot		= 22;
	const				PTK_UnaryIsNull		= 23;
	const				PTK_UnaryIsNotNull	= 24;
	const				PTK_UnaryExists		= 25;
	const				PTK_UnaryNotExists	= 26;
	const				PTK_BinaryPlus		= 27;
	const				PTK_BinaryMinus		= 28;
	const				PTK_BinaryMultiply	= 29;
	const				PTK_BinaryDivide	= 30;
	const				PTK_BinaryEquals	= 31;
	const				PTK_BinaryNotEquals	= 32;
	const				PTK_BinaryGreater	= 33;
	const				PTK_BinaryLower		= 34;
	const				PTK_BinaryGreaterEquals	= 35;
	const				PTK_BinaryLowerEquals	= 36;
	const				PTK_BinaryLike		= 37;
	const				PTK_BinaryAnd		= 38;
	const				PTK_BinaryOr		= 39;
	const				PTK_BinaryIn		= 40;
	const				PTK_BinaryNotIn		= 41;
	const				PTK_Case		= 42;
	const				PTK_When		= 43;

	const				PTK_Select		= 50;
	const				PTK_Update		= 51;
	const				PTK_Delete		= 52;

	abstract function		visit($treeVisitor);
}

abstract class StatementTree extends ParserTree
{
	function			getFroms()
	{
		return $this->froms;
	}

	function			getWhere()
	{
		return $this->where;
	}

	function			getOrderBys()
	{
		return $this->orderBys;
	}

	public				$froms;
	public				$where;
	public				$orderBys;
}

class SelectTree extends StatementTree
{
	function			visit($treeVisitor)
	{
		return $treeVisitor->visitSelect($this);
	}

	function			getKind()
	{
		return self::PTK_Select;
	}

	function			getItems()
	{
		return $this->items;
	}

	function			getGroupBys()
	{
		return $this->groupBys;
	}

	function			getHaving()
	{
		return $this->having;
	}

	public				$items;
	public				$having;
	public				$groupBys;
}

abstract class ActionTree extends StatementTree
{
}

class DeleteTree extends ActionTree
{
	function			visit($treeVisitor)
	{
		return $treeVisitor->visitDelete($this);
	}

	function			getKind()
	{
		return self::PTK_Delete;
	}

}

class UpdateTree extends ActionTree
{
	function			visit($treeVisitor)
	{
		return $treeVisitor->visitUpdate($this);
	}

	function			getKind()
	{
		return self::PTK_Update;
	}

	function			getSets()
	{
		return $this->sets;
	}

	public				$sets;
}

abstract class ExpressionTree extends ParserTree
{
	/**
	 * Value specific for context.
	 */
	public				$helper;
}

class IdentifierTree extends ExpressionTree
{
	function			__construct($name)
	{
		$this->name = $name;
	}

	function			visit($treeVisitor)
	{
		return $treeVisitor->visitIdentifier($this);
	}

	function			getKind()
	{
		return self::PTK_Identifier;
	}

	function			getName()
	{
		return $this->name;
	}

	public				$name;
}

class MemberTree extends ExpressionTree
{
	function			__construct($path, $member)
	{
		$this->path = $path;
		$this->member = $member;
	}

	function			visit($treeVisitor)
	{
		return $treeVisitor->visitMember($this);
	}

	function			getKind()
	{
		return self::PTK_Member;
	}

	function			getPath()
	{
		return $this->path;
	}

	function			getMember()
	{
		return $this->member;
	}

	public				$path;
	public				$member;
}

class CallTree extends ExpressionTree
{
	function			__construct($path, $args)
	{
		$this->path = $path;
		$this->args = $args;
	}

	function			visit($treeVisitor)
	{
		return $treeVisitor->visitCall($this);
	}

	function			getKind()
	{
		return self::PTK_Call;
	}

	function			getPath()
	{
		return $this->path;
	}

	function			getArgs()
	{
		return $this->args;
	}

	public				$path;
	public				$args;
}

class StarTree extends IdentifierTree
{
	function			__construct($name)
	{
		parent::__construct($name);
	}

	function			visit($treeVisitor)
	{
		return $treeVisitor->visitStar($this);
	}

	function			getKind()
	{
		return ParserTree::PTK_Star;
	}
}

abstract class LiteralTree extends ExpressionTree
{
	function			__construct($content)
	{
		$this->content = $content;
	}

	function			getContent()
	{
		return $this->content;
	}

	public				$content;
}

class NullTree extends LiteralTree
{
	function			__construct($content)
	{
		parent::__construct($content);
	}

	function			visit($treeVisitor)
	{
		return $treeVisitor->visitNull($this);
	}

	function			getKind()
	{
		return ParserTree::PTK_Null;
	}
}

class StringTree extends LiteralTree
{
	function			__construct($content)
	{
		parent::__construct($content);
	}

	function			visit($treeVisitor)
	{
		return $treeVisitor->visitString($this);
	}

	function			getKind()
	{
		return ParserTree::PTK_String;
	}
}

class NumberTree extends LiteralTree
{
	function			__construct($content)
	{
		parent::__construct($content);
	}

	function			visit($treeVisitor)
	{
		return $treeVisitor->visitNumber($this);
	}

	function			getKind()
	{
		return ParserTree::PTK_Number;
	}
}

abstract class PlacementTree extends ParserTree
{
	function			__construct()
	{
	}
}

class NumberedPlacementTree extends PlacementTree
{
	function			__construct($position)
	{
		$this->position = $position;
	}

	function			visit($treeVisitor)
	{
		return $treeVisitor->visitNumberedPlacement($this);
	}

	function			getKind()
	{
		return ParserTree::PTK_NumberedPlacement;
	}

	function			getPosition()
	{
		return $this->position;
	}

	public				$position;
}

class NamedPlacementTree extends PlacementTree
{
	function			__construct($position)
	{
		$this->position = $position;
	}

	function			visit($treeVisitor)
	{
		return $treeVisitor->visitNamedPlacement($this);
	}

	function			getKind()
	{
		return ParserTree::PTK_NamedPlacement;
	}

	function			getPosition()
	{
		return $this->position;
	}

	public				$position;
}

class ParenthesizedTree extends ExpressionTree
{
	function			__construct($expression)
	{
		$this->expression = $expression;
	}

	function			getExpression()
	{
		return $this->expression;
	}

	function			visit($treeVisitor)
	{
		return $treeVisitor->visitParenthesized($this);
	}

	function			getKind()
	{
		return ParserTree::PTK_Parenthesized;
	}

	public				$expression;
}

class SelectItemTree extends ParserTree
{
	function			__construct($expression)
	{
		$this->expression = $expression;
	}

	function			visit($treeVisitor)
	{
		return $treeVisitor->visitSelectField($this);
	}

	function			getKind()
	{
		return self::PTK_SelectItem;
	}

	function			getAlias()
	{
		return $this->alias;
	}

	function			getExpression()
	{
		return $this->expression;
	}

	public				$alias;
	public				$expresssion;
}

abstract class FromSourceTree extends ParserTree
{
	function			__construct($alias)
	{
		$this->alias = $alias;
	}

	function			getAlias()
	{
		return $this->alias;
	}

	public				$alias;
}

class EntitySourceTree extends FromSourceTree
{
	function			__construct($alias, $table)
	{
		parent::__construct($alias);
		$this->table = $table;
	}

	function			visit($treeVisitor)
	{
		return $treeVisitor->visitEntitySource($this);
	}

	function			getKind()
	{
		return self::PTK_TableSource;
	}

	function			getTable()
	{
		return $this->table;
	}

	public				$table;
}

class SubSourceTree extends FromSourceTree
{
	function			__construct($select)
	{
		$this->select = $select;
	}

	function			visit($treeVisitor)
	{
		return $treeVisitor->visitSubSource($this);
	}

	function			getKind()
	{
		return ParserTree::PTK_SubSource;
	}

	function			getSelect()
	{
		return $this->select;
	}

	public				$select;
}

class OrderByItemTree extends ParserTree
{
	function			__construct($expression)
	{
		$this->expression = $expression;
	}

	function			visit($treeVisitor)
	{
		return $treeVisitor->visitOrderByItem($this);
	}

	function			getKind()
	{
		return self::PTK_OrderByItem;
	}

	function			getDirection()
	{
		return $this->direction;
	}

	function			getExpression()
	{
		return $this->expression;
	}

	public				$direction;
	public				$expresssion;
}

class TupleTree extends ExpressionTree
{
	function			__construct($expressions)
	{
		$this->expressions = $expressions;
	}

	function			getExpressions()
	{
		return $this->expressions;
	}

	function			visit($treeVisitor)
	{
		return $treeVisitor->visitTuple($this);
	}

	function			getKind()
	{
		return ParserTree::PTK_Tuple;
	}

	public				$expressions;
}

class UnaryOperationTree extends ParserTree
{
	function			__construct($operation, $operand)
	{
		$this->operation = $operation;
		$this->operand = $operand;
	}

	function			visit($treeVisitor)
	{
		return $treeVisitor->visitUnaryOperation($this);
	}

	function			getKind()
	{
		return self::$operationMap[$this->operation];
	}

	function			getOperation()
	{
		return $this->operation;
	}

	function			getOperand()
	{
		return $this->operand;
	}

	public				$operation;
	public				$operand;

	public static			$operationMap = array(
		"+"				=> ParserTree::PTK_UnaryPlus,
		"-"				=> ParserTree::PTK_UnaryMinus,
		"NOT"				=> ParserTree::PTK_UnaryNot,
		"IS NULL"			=> ParserTree::PTK_UnaryIsNull,
		"IS NOT NULL"			=> ParserTree::PTK_UnaryIsNotNull,
		"EXISTS"			=> ParserTree::PTK_UnaryExists,
		"NOT EXISTS"			=> ParserTree::PTK_UnaryNotExists,
	);
}

class BinaryOperationTree extends ParserTree
{
	function			__construct($operation, $left, $right)
	{
		$this->operation = $operation;
		$this->operands = array($left, $right);
	}

	function			visit($treeVisitor)
	{
		return $treeVisitor->visitBinaryOperation($this);
	}

	function			getKind()
	{
		return self::$operationMap[$this->operation];
	}

	function			getOperation()
	{
		return $this->operation;
	}

	function			getOperands()
	{
		return $this->operands;
	}

	public				$operation;
	public				$operands;

	public static			$operationMap = array(
		"+"				=> ParserTree::PTK_BinaryPlus,
		"-"				=> ParserTree::PTK_BinaryMinus,
		"*"				=> ParserTree::PTK_BinaryMultiply,
		"/"				=> ParserTree::PTK_BinaryDivide,
		"="				=> ParserTree::PTK_BinaryEquals,
		"!="				=> ParserTree::PTK_BinaryNotEquals,
		">"				=> ParserTree::PTK_BinaryGreater,
		">="				=> ParserTree::PTK_BinaryGreaterEquals,
		"<"				=> ParserTree::PTK_BinaryLower,
		"<="				=> ParserTree::PTK_BinaryLowerEquals,
		"LIKE"				=> ParserTree::PTK_BinaryLike,
		"AND"				=> ParserTree::PTK_BinaryAnd,
		"OR"				=> ParserTree::PTK_BinaryOr,
		"IN"				=> ParserTree::PTK_BinaryIn,
		"NOT IN"			=> ParserTree::PTK_BinaryNotIn,
	);
}

class WhenTree extends ParserTree
{
	function			__construct($conditionTree, $valueTree)
	{
		$this->conditionTree = $conditionTree;
		$this->valueTree = $valueTree;
	}

	function			visit($treeVisitor)
	{
		return $treeVisitor->visitWhenOperation($this);
	}

	function			getKind()
	{
		return ParserTree::PTK_When;
	}

	function			getConditionTree()
	{
		return $this->conditionTree;
	}

	function			getValueTree()
	{
		return $this->valueTree;
	}

	public				$conditionTree;
	public				$valueTree;
}

class CaseTree extends ParserTree
{
	function			__construct($whenTrees, $elseTree)
	{
		$this->whenTrees = $whenTrees;
		$this->elseTree = $elseTree;
	}

	function			visit($treeVisitor)
	{
		return $treeVisitor->visitCaseOperation($this);
	}

	function			getKind()
	{
		return ParserTree::PTK_Case;
	}

	function			getWhenTrees()
	{
		return $this->whenTrees;
	}

	function			getElseTree()
	{
		return $this->elseTree;
	}

	public				$whenTrees;
	public				$elseTree;
}


class JqlParser
{
	function			__construct()
	{
	}

	function			parse($jql)
	{
		$this->jql = $jql;
		$this->len = strlen($jql);

		try {
			$result = $this->parseSubTree();
			if ($this->pos < $this->len)
				throw new \RuntimeException("Unprocessed characters behind the end of JQL string");
		}
		catch (\Exception $ex) {
			throw new \RuntimeException($ex->getMessage().", parsing: ".$this->getRest(), -1, $ex);
		}
		return $result;
	}

	function			parseSubTree()
	{
		$token = $this->needToken();
		switch ($token) {
		case "FROM":
			return $this->parseShortSelectTree();

		case "SELECT":
			return $this->parseSelectTree();

		case "UPDATE":
			return $this->parseUpdateTree();

		case "DELETE":
			return $this->parseDeleteTree();

		default:
			throw new \RuntimeException("unsupported: ".$token);
		}
	}

	function			isKeyword($word)
	{
		return array_key_exists($word, self::$keywords);
	}

	function			parseOneFrom()
	{
		$token = $this->needToken();
		if ($this->isKeyword($token)) {
			switch ($token) {
			case "(":
				$tree = new SubSourceTree($this->parseSubTree());
				$this->requireToken(")");
				$tree->alias = $this->needWordToken();
				break;

			default:
				throw new \RuntimeException("expected table, got: ".$token);
			}
		}
		else {
			$alias = $this->checkToken();
			if (!is_null($alias)) {
				if ($this->isKeyword($alias)) {
					$this->unshiftToken($alias);
					$alias = null;
				}
			}
			$tree = new EntitySourceTree($alias, $token);
		}
		return $tree;
	}

	function			parseSelectFrom()
	{
		$tree = $this->parseOneFrom();
		for (;;) {
			$token = $this->checkToken();
			if (is_null($token))
				return $tree;
			switch ($token) {
			case "INNER":
			case "LEFT":
			case "RIGHT":
				$this->requireToken("JOIN");
				$joined = $this->parseOneFrom();
				$tree = new JoinSourceTree($token, $tree, $joined);
				break;

			default:
				$this->unshiftToken($token);
				return $tree;
			}
		}
	}

	function			parseMember()
	{
		$token = $this->needToken();
		$c = substr($token, 0, 1);
		if (!ctype_alpha($c)) {
			throw new \RuntimeException("expected member, got ".$token);
		}
		return $token;
	}

	function			parseParenthesis()
	{
		$token = $this->needToken("operand");
		if ($token == "SELECT") {
			$tree = new ParenthesizedTree($this->parseSelectTree());
			$this->requireToken(")");
		}
		else {
			$this->unshiftToken($token);
			if (is_null($expression = $this->parseExpression()))
				throw new \RuntimeException("expected expression after (");
			$token = $this->needToken("expression-end");
			if ($token == ",") {
				$items = array($expression);
				while ($token == ",") {
					if (is_null($expression = $this->parseExpression()))
						throw new \RuntimeException("expected expression after ( ,");
					array_push($items, $expression);
					$token = $this->needToken("expression-end");
				}
				$tree = new ParenthesizedTree(new TupleTree($items));
			}
			else {
				$tree = new ParenthesizedTree($expression);
			}
			if ($token != ")")
				throw new \RuntimeException("expected closing parenthesis, got $token");
		}
		return $tree;
	}

	function			parseOperand($stopPriority)
	{
		$path = null;
		$token = $this->checkToken();
		if (is_null($token))
			throw new \RuntimeException("expected operand, got end");
		$priority = isset(self::$unaryOperators[$token]) ? self::$unaryOperators[$token] : null;
		switch ($token) {
		case "NOT":
			if (is_null($operand = $this->parseOperand($priority)))
				throw new \RuntimeException("expected operand after NOT");
			$tree = new UnaryOperationTree($token, $operand);
			break;

		case "-":
			if (is_null($operand = $this->parseOperand($priority)))
				throw new \RuntimeException("expected operand after -");
			$tree = new UnaryOperationTree($token, $operand);
			break;

		case "(":
			$tree = $this->parseParenthesis();
			break;

		case ")":
			$this->unshiftToken($token);
			throw new \RuntimeException("expected operand, got $token");

		case "*":
			$tree = new StarTree($token);
			break;

		case "NULL":
			$tree = new NullTree($token);
			break;

		case "CASE":
			$tree = $this->parseCase();
			break;

		case "?":
			$position = $this->needToken("placementId");
			if (ctype_digit(substr($position, 0, 1))) {
				$tree = new NumberedPlacementTree(intval($position));
			}
			else {
				throw new \RuntimeException("expected number after ? placement: ".$position);
			}
			break;

		case ":":
			$position = $this->needToken("placementId");
			if (ctype_alpha(substr($position, 0, 1))) {
				$tree = new NamedPlacementTree($position);
			}
			else {
				throw new \RuntimeException("expected word after : placement: ".$position);
			}
			break;

		default:
			if ($this->isKeyword($token)) {
				$this->unshiftToken($token);
				throw new \RuntimeException("expected operand, got $token");
			}
			$c = substr($token, 0, 1);
			if ($c == "'" || $c == "\"") {
				$tree = new StringTree($token);
				break;
			}
			if (ctype_digit($c)) {
				$tree = new NumberTree($token);
				break;
			}
			if (ctype_alpha($c) || $c == "_") {
				$path = new IdentifierTree($token);
				for (;;) {
					$token = $this->checkToken();
					if ($token == ".") {
						$path = new MemberTree($path, $this->parseMember());
					}
					else {
						break;
					}
				}
				if ($token == "(") {
					$tree = new CallTree($path, $this->parseArgumentList());
					$this->requireToken(")");
					break;
				}
				else {
					$this->unshiftToken($token);
					$tree = $path;
					break;
				}
			}
			$this->unshiftToken($token);
			throw new \RuntimeException("expected operand, got $token");
		}
		while (!is_null($token = $this->checkToken()) && isset(self::$binaryOperators[$token]) && self::$binaryOperators[$token] < $stopPriority) {
			$tree = new BinaryOperationTree($token, $tree, $this->parseOperand(self::$binaryOperators[$token]));
		}
		if (!is_null($token))
			$this->unshiftToken($token);
		return $tree;
	}

	function			parseCase()
	{
		$whenTrees = array();
		$elseTree = array();

		$status = 0;
		for (;;) {
			$token = $this->checkToken();
			if (is_null($token))
				throw new \RuntimeException("WHEN, ELSE or END expected, got end");
			switch ($token) {
			case "WHEN":
				if ($status > 1)
					throw new \RuntimeException("Got unexpected WHEN");
				$status = 1;
				$conditionTree = $this->parseExpression();
				$token = $this->needToken("THEN");
				$valueTree = $this->parseExpression();
				array_push($whenTrees, new WhenTree($conditionTree, $valueTree));
				break;

			case "ELSE":
				if ($status >= 2)
					throw new \RuntimeException("Got unexpected ELSE");
				$status = 2;
				$elseTree = $this->parseExpression();
				break;

			case "END":
				if ($status < 2)
					throw new \RuntimeException("Got unexpected END without ELSE block");
				return new CaseTree($whenTrees, $elseTree);

			default:
				throw new \RuntimeException("WHEN, ELSE or END expected, got: ".$token);
			}
		}
	}

	function			parseExpression()
	{
		return $this->parseOperand(10000);
	}

	function			parseExpressionList()
	{
		$expressions = array($this->parseExpression());
		for (;;) {
			$token = $this->checkToken();
			if ($token != ",") {
				$this->unshiftToken($token);
				return $expressions;
			}
			array_push($expressions, $this->parseExpression());
		}
	}

	function			parseArgumentList()
	{
		$token = $this->checkToken();
		$this->unshiftToken($token);
		if ($token == ")")
			return array();
		$expressions = array($this->parseExpression());
		for (;;) {
			$token = $this->checkToken();
			if ($token != ",") {
				$this->unshiftToken($token);
				return $expressions;
			}
			array_push($expressions, $this->parseExpression());
		}
	}

	function			parseOrderBys()
	{
		$items = array();
		$expression = $this->parseExpression();
		for (;;) {
			$item = new OrderByItemTree($expression);
			array_push($items, $item);
			$token = $this->checkToken();
			if ($token == "DESC") {
				$item->direction = "DESC";
				$token = $this->checkToken();
			}
			elseif ($token == "ASC") {
				$item->direction = "ASC";
				$token = $this->checkToken();
			}
			if (is_null($token) || $token != ",") {
				$this->unshiftToken($token);
				return $items;
			}
			$expression = $this->parseExpression();
		}
	}

	function			parseShortSelectTree()
	{
		$tree = new SelectTree();
		$tree->items = null;
		$froms = array($this->parseSelectFrom());
		$token = $this->checkToken();
		while ($token == ",") {
			array_push($froms, $this->parseTable());
		}
		$tree->froms = $froms;

		if ($token == "WHERE") {
			$tree->where = $this->parseExpression();
			$token = $this->checkToken();
		}

		if ($token == "GROUP") {
			$this->requireToken("BY");
			$tree->groupBys = $this->parseExpressionList();
			$token = $this->checkToken();
		}

		if ($token == "HAVING") {
			$tree->having = $this->parseExpression();
			$token = $this->checkToken();
		}

		if ($token == "ORDER") {
			$this->requireToken("BY");
			$tree->orderBys = $this->parseOrderBys();
			$token = $this->checkToken();
		}

		$this->unshiftToken($token);

		return $tree;
	}

	function			parseSelectItems()
	{
		$items = array();
		$expression = $this->parseExpression();
		for (;;) {
			$item = new SelectItemTree($expression);
			array_push($items, $item);
			$token = $this->needToken();
			if ($token == "FROM") {
				$this->unshiftToken($token);
				return $items;
			}
			if (preg_match('/^\w/', $token)) {
				$item->alias = $token;
				$token = $this->needToken();
			}
			if ($token == ",") {
				$expression = $this->parseExpression();
			}
			else {
				throw new \RuntimeException("unexpected token: ".$token);
			}
		}
	}

	function			parseSelectTree()
	{
		$tree = new SelectTree();
		$items = $this->parseSelectItems();

		$token = $this->needToken("FROM");
		$tree->items = $items;
		$froms = array($this->parseSelectFrom());
		$token = $this->checkToken();
		while ($token == ",") {
			array_push($froms, $this->parseSelectFrom());
			$token = $this->checkToken();
		}
		$tree->froms = $froms;

		if ($token == "WHERE") {
			$tree->where = $this->parseExpression();
			$token = $this->checkToken();
		}

		if ($token == "GROUP") {
			$this->requireToken("BY");
			$tree->groupBys = $this->parseExpressionList();
			$token = $this->checkToken();
		}

		if ($token == "HAVING") {
			$tree->having = $this->parseExpression();
			$token = $this->checkToken();
		}

		if ($token == "ORDER") {
			$this->requireToken("BY");
			$tree->orderBys = $this->parseOrderBys();
			$token = $this->checkToken();
		}

		$this->unshiftToken($token);

		return $tree;
	}

	function			parseUpdateTree()
	{
		$tree = new UpdateTree();
		$token = $this->needToken();
		if ($token != "FROM") {
			$this->unshiftToken($token);
		}
		$tree->froms = $this->parseOneFrom();
		$token = $this->requireToken("SET");

		if ($token == "SET") {
			$tree->sets = $this->parseExpressionList();
			$token = $this->checkToken();
		}

		if (!is_null($token) && $token == "WHERE") {
			$tree->where = $this->parseExpression();
			$token = $this->checkToken();
		}

		if (!is_null($token) && $token == "ORDER") {
			$this->requireToken("BY");
			$tree->orderBys = $this->parseOrderBys();
			$token = $this->checkToken();
		}

		if (!is_null($token))
			throw new \RuntimeException("unexpected token: $token");

		return $tree;
	}

	function			parseDeleteTree()
	{
		$tree = new DeleteTree();
		$token = $this->needToken();
		if ($token != "FROM") {
			$this->unshiftToken($token);
		}
		$tree->froms = $this->parseOneFrom();
		$token = $this->checkToken();

		if (!is_null($token) && $token == "WHERE") {
			$tree->where = $this->parseExpression();
			$token = $this->checkToken();
		}

		if (!is_null($token) && $token == "ORDER") {
			$this->requireToken("BY");
			$tree->orderBys = $this->parseOrderBys();
			$token = $this->checkToken();
		}

		if (!is_null($token))
			throw new \RuntimeException("unexpected token: $token");

		return $tree;
	}

	function			getRest()
	{
		return substr($this->jql, $this->pos);
	}

	function			unshiftToken($token)
	{
		$this->pendingToken = $token;
	}

	function			checkToken()
	{
		if (!is_null($this->pendingToken)) {
			$word = $this->pendingToken;
			$this->pendingToken = null;
			return $word;
		}

		while ($this->pos < $this->len) {
			$c = $this->getNextChar();
			if (ctype_space($c))
				continue;
			if (ctype_alpha($c) || $c == "_") {
				$word = $c;
				while (ctype_alnum($nc = $this->lookNextChar()) || $nc == "_") {
					$word .= $this->getNextChar();
				}
				return $word;
			}
			elseif ($c == ".") {
				return ".";
			}
			elseif ($c == "'") {
				$start = $this->pos;
				$word = $c;
				for (;;) {
					if ($this->isEnd())
						throw new \RuntimeException("unfinished string starting at ".$start);
					$c = $this->getNextChar();
					$word .= $c;
					if ($c == "'")
						return $word;
					if ($c == "\\")
						$word .= $this->getNextChar();
				}
			}
			elseif ($c == "\"") {
				$start = $this->pos;
				$word = $c;
				for (;;) {
					if ($this->isEnd())
						throw new \RuntimeException("unfinished string starting at ".$start);
					$c = $this->getNextChar();
					$word .= $c;
					if ($c == "\"")
						return $word;
					if ($c == "\\")
						$word .= $this->getNextChar();
				}
			}
			elseif (ctype_digit($c)) {
				$word = $c;
				while (ctype_digit(($c = $this->lookNextChar())) || $c == ".")
					$word .= $this->getNextChar();
				return $word;
			}
			else {
				$word = $c;
				while (array_key_exists($word.$this->lookNextChar(), self::$keywords)) {
					$word .= $this->getNextChar();
				}
				if (!array_key_exists($word, self::$keywords)) {
					throw new \RuntimeException("unexpected token in JQL: ".$word);
				}
				switch ($word) {
				case "/*":
					if (($p = strpos($this->jql, "*/", $this->pos)) === false)
						throw new \RuntimeException("cannot find end of the comment started at ".$this->pos);
					$this->pos = $p+2;
					continue;

				case "--":
					if (($p = strpos($this->jql, "\n", $this->pos)) === false)
						throw new \RuntimeException("cannot find end of the comment started at ".$this->pos);
					$this->pos = $p+1;
					continue;
				}
				return $word;
			}
		}
		return null;
	}

	function			needToken($tokenName = null)
	{
		if (is_null($token = $this->checkToken()))
			throw new \RuntimeException("unexpected end (required $tokenName) of JQL at position ".$this->pos);
		return $token;
	}

	function			needWordToken($tokenName = null)
	{
		$token = $this->needToken();
		if ($this->isKeyword($token))
			throw new \RuntimeException("expected word token (required $tokenName), got a keyword before ".$this->getRest());
		return $token;
	}

	function			requireToken($required)
	{
		if (($token = $this->needToken()) != $required)
			throw new \RuntimeException("unexpected token ".$token.", required ".$required);
		return $token;
	}

	function			getNextChar()
	{
		if ($this->pos >= $this->len)
			throw new \RuntimeException("parsing behind end");
		return substr($this->jql, $this->pos++, 1);
	}

	function			isEnd()
	{
		return $this->pos >= $this->len;
	}

	function			lookNextChar()
	{
		return $this->pos < $this->len ? substr($this->jql, $this->pos, 1) : "\x00"; 
	}

	public				$jql;
	public				$len;
	public				$pos;
	public				$pendingToken;

	public static			$keywords;
	public static			$unaryOperators;
	public static			$binaryOperators;
};

JqlParser::$keywords = array_fill_keys(array(
		"/*",
		"--",
		"'",
		".",
		",",
		"(",
		")",
		"==",
		"!=",
		"<=",
		">=",
		"<",
		">",
		"=",
		"+",
		"-",
		"*",
		"/",
		"?",
		":",
		"SELECT",
		"UPDATE",
		"DELETE",
		"INSERT",
		"FROM",
		"INNER",
		"LEFT",
		"RIGHT",
		"JOIN",
		"ON",
		"SET",
		"WHERE",
		"NOT",
		"IS",
		"CASE",
		"WHEN",
		"THEN",
		"ELSE",
		"END",
		"IN",
		"EXISTS",
		"LIKE",
		"AND",
		"OR",
		"GROUP",
		"BY",
		"HAVING",
		"ORDER",
		"BY",
		"ASC",
		"DESC",
		"NULL",
	), 1
);

JqlParser::$unaryOperators = array(
	"-"			=> 20,
	"NOT"			=> 20,
);

JqlParser::$binaryOperators = array(
	"."			=> 5,
	"*"			=> 10,
	"/"			=> 10,
	"+"			=> 20,
	"-"			=> 20,
	"=="			=> 30,
	"!="			=> 30,
	"<="			=> 30,
	">="			=> 30,
	"<"			=> 30,
	">"			=> 30,
	"="			=> 30,
	"IS"			=> 30,
	"IN"			=> 30,
	"LIKE"			=> 30,
	"AND"			=> 40,
	"OR"			=> 40,
);


?>
